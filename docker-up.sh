#!/bin/bash 

if [ -d "local/dockerbuild" ]; then
    echo "use local/dockerbuild"
	cd local/dockerbuild
else
	echo "use dockerbuild"
    cd dockerbuild 
fi

docker compose -f transfashionid.yml up -d