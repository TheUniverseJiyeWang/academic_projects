
#!/bin/bash

on_exit(){
 docker container stop $varcontainerid
 docker container rm $varcontainerid
 docker image rm j_wang_a2
}

on_sigint(){
 docker container stop $varcontainerid
 docker container rm $varcontainerid
 docker image rm j_wang_a2
}

trap on_exit EXIT
trap on_sigint SIGINT

varcurpath=$(realpath ${BASH_SOURCE})
varout=${varcurpath%script_j_wang.sh}"out"
echo $varout
rm -r $varout
mkdir $varout
cd $varout
wget http://lnx.cs.smu.ca/docker/Dockerfile
wget http://lnx.cs.smu.ca/docker/app.py
vardate=$(date "+%d")
varremainder=$(($vardate%2))
echo $vardate
echo $varremainder
if [ $varremainder == 0 ]
then
 sed -i 's/Hello World!/Today is an even day/g' app.py
else
 sed -i 's/Hello World!/Today is an odd day/g' app.py
fi

for i in {2000..3000}
do
 nc -w 10 -z 0.0.0.0 $i
 status=$(echo $?)
 if [ $status == 0 ]
 then
  echo $i
 else
  echo "port not in use"
  varcurport=$i
  break
 fi
done
echo $varcurport

docker build -t j_wang_a2 .
docker run -d -p $varcurport:80 j_wang_a2
varcontainer=$(docker container ls| grep 'j_wang_a2')
echo $varcontainer
varcontainerid=${varcontainer:0:12}
echo $varcontainerid
varcontainerip=$(docker inspect --format="{{ .NetworkSettings.IPAddress }}" $varcontainerid)
echo "Container's IP is" $varcontainerip >&2
varurl=$(echo "lnx.cs.smu.ca:"$varcurport)
echo $varurl
sleep 5
curl -s $varurl
if [ $? -ne 0 ]
then
 echo "There is an error on the web page."
 exit 1
else
 echo "The web page works perfectly."
fi

curl $varurl -o serv.html

ssh -R $varcurport:0.0.0.0:$varcurport -N -f ji_wang@dev.cs.smu.ca "wget dev.cs.smu.ca localhost:$varcurport"
sleep 5
if [ $? -eq 0 ]
then
 echo "succeeded setup remote port"
else
 echo "failed"
fi

echo "success"
echo  $?
