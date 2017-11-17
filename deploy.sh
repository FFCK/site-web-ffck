#!/usr/bin/env bash
source ./env.sh
docker deploy --with-registry-auth --compose-file docker-compose.yml ffck
