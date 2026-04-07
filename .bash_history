ls -ltr
tar xvzfp replus_data_260324.tar.gz 
ls -ltr
mysql -u buyback -p db_buyback < replus_db_260324-2.sql 
apachectl configtest && systemctl reload httpd
sudo systemctl restart httpd
mysqldump -u buyback -p db_buyback > buyback_db_260327.sql 
tar cvzfp buyback_data_260327.tar.gz ./*
ls -ltr
tar cvzfp buyback_data_260331.tar.gz ./*
mysqldump -u buyback -p db_buyback > buyback_db_260331.sql 
mysql -u root -p
