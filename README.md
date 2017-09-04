# api.eelly.com

## Install
```
git clone https://github.com/runphp/api.eelly.com
cd api.eelly.com
sudo docker run -p 80:80 -p 443:443 -v $PWD:/var/www/api.eelly.com --name=api.eelly.com runphp/api.eelly.com
sudo docker exec -it api.eelly.com composer install -d api.eelly.com -vvv
```
