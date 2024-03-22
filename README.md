backup dữ liệu
 mysqldump -u root -p phptest > backup.sql

Get-Content ./backup.sql | mysql -u root -p -D phptest   
khôi phục dữ liệu