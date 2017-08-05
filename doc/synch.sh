cd `dirname $0`
rsync -vzrtu --progress --password-file=.pwd --exclude-from=yii.exclude ../ root@123.56.14.166::knowledge