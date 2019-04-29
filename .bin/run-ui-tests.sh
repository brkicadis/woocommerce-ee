#!/bin/bash
set -e # Exit with nonzero exit code if anything fails
#get version
export VERSION=`jq .[0].release SHOPVERSIONS`

# download and install ngrok
curl -s https://bin.equinox.io/c/4VmDzA7iaHb/ngrok-stable-linux-amd64.zip > ngrok.zip
unzip ngrok.zip
chmod +x $PWD/ngrok
# Download json parser for determining ngrok tunnel
curl -sO http://stedolan.github.io/jq/download/linux64/jq
chmod +x $PWD/jq

# Open ngrok tunnel
$PWD/ngrok authtoken $NGROK_TOKEN
TIMESTAMP=$(date +%s)
$PWD/ngrok http 9090 -subdomain="${TIMESTAMP}-woo-${GATEWAY}" > /dev/null &


# extract the ngrok url
NGROK_URL=$(curl -s localhost:4040/api/tunnels/command_line | jq --raw-output .public_url)
# allow ngrok to initialize
while [ ! ${NGROK_URL} ] || [ ${NGROK_URL} = 'null' ];  do
    echo "Waiting for ngrok to initialize"
    export NGROK_URL=$(curl -s localhost:4040/api/tunnels/command_line | jq --raw-output .public_url)
    sleep 1
done

#start shopsystem and demoshop
bash .bin/start-shopsystem.sh

#run tests
cd wirecard-woocommerce-extension && vendor/bin/codecept run acceptance checkCreditCard3DSFunctionalityHappyPath.feature --html --xml

if [[ ${GATEWAY} = "API-TEST" ]]; then
	vendor/bin/codecept run acceptance checkPayPalFunctionalityHappyPath.feature --html --xml
fi
