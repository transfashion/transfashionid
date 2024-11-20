#!/bin/bash 

URL="http://localhost:8007/api/Transfashion/Transfashionid/TestApi/Coba"

echo POST $URL
curl -X POST \
     -D - \
	 -H "Content-Type: application/json" \
     -d '{"request":{"kedua": "isi kedua", "pertama": "isi pertama" }}' \
	 $URL



