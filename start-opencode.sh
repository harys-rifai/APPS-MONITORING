#!/bin/bash

# Opencode Start Script for Bash
cd "$(dirname "$0")"

echo "Starting Opencode on port 46270..."

# Check if opencode is installed
if ! command -v opencode &> /dev/null
then
    echo "opencode could not be found, installing opencode-ai globally..."
    npm install -g opencode-ai
fi

opencode --port 46270
