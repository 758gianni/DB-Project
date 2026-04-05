#!/bin/bash

user="u66"
pass="Kitchen.Orderly.Write.Shake.35"
db="u66"

# MAKE TABLES
echo "source make_tables.sql;" | mysql -u "$user" --password="$pass" "$db"

# SUPPLIERS
echo "db.suppliers.drop()" | mongo "$db" -u "$user" -p "$pass"
mongoimport -d "$db" -c suppliers -u "$user" --password="$pass" --type="json" --jsonArray --file="suppliers_100.json" 
mongoexport -d "$db" -c suppliers -u "$user" -p "$pass" --type=csv --fields "_id,name,email" | tail -n +2 > suppliers.csv
cat suppliers.csv  | tr "," "\t" > suppliers.tsv

# ORDERS, ORDER_PART
echo "db.orders.drop()" | mongo "$db" -u "$user" -p "$pass"
mongoimport -d "$db" -c orders -u "$user" --password="$pass" --type="json" --file="orders_4000.json" 
mongoexport -d "$db" -c orders -u "$user" -p "$pass" --jsonArray > orders.json
jq -r 'to_entries[] | "\(.key+1)\t\(.value.supp_id)\t\(.value.when)"' orders.json > orders.tsv
jq -r 'to_entries[] as $o | $o.value.items[] | "\($o.key+1)\t\(.part_id)\t\(.qty)"' orders.json > order_part.tsv

# LOAD INTO DB
echo "load data local infile 'suppliers.tsv' into table suppliers fields terminated by '\t';" | mysql "$db" -u "$user" --password="$pass" --local-infile=1
echo "load data local infile 'orders.tsv' into table orders fields terminated by '\t' (_id, supp_id, \`when\`);" | mysql "$db" -u "$user" --password="$pass" --local-infile=1
echo "load data local infile 'order_part.tsv' into table order_part fields terminated by '\t' (order_id, part_id, qty);" | mysql "$db" -u "$user" --password="$pass" --local-infile=1
