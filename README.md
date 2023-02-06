Configuration for docker

NEW IMPLEMENTATION TO SERVER!!! 20230206

docker run --name myXampp5 -p 41051:22 -p 41052:80 -p 41053:443 -p 41054:3306 -d -v d:/DEV/xampp5:/www -v myXampp5db:/opt/lampp/var/mysql tomsik68/xampp:5