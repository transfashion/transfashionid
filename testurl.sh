#!/bin/bash 

# export PS1='\[\033[32m\]\u@\h\[\033[0m\]:\[\033[34m\]\W\[\033[0m\]\$ '
# export PS1='\[\033[34m\]\W\[\033[0m\]\$ '


URL="http://localhost:8007/api/Transfashion/Transfashionid/TestApi/Coba"

echo POST $URL
curl -X POST \
     -D - \
	 -H "Content-Type: application/json" \
     -d '{"request":{"kedua": "isi kedua", "pertama": "isi pertama" }}' \
	 $URL



