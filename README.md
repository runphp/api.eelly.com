# api.eelly.com

## Install
```
git clone https://github.com/runphp/api.eelly.com
cd api.eelly.com
sudo docker run -p 80:80 -p 443:443 -v $PWD:/var/www/api.eelly.com runphp/api.eelly.com
sudo docker exec -it $(docker ps -a|grep '443/tcp'|awk '{print $1}') composer install -d api.eelly.com -vvv
```
