cd `dirname $0`
rsync -vzrtu --progress --password-file=.pwd --exclude-from=yii.exclude ../ root@39.108.160.44:/var/www/benefit/