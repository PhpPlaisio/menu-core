#!/bin/bash -e -x

cat test/ddl/0010_create_database.sql                            | mysql -v -u root      -h 127.0.0.1
cat test/ddl/0020_create_user.sql                                | mysql -v -u root      -h 127.0.0.1
cat vendor/plaisio/db-company/lib/ddl/0100_create_tables.sql     | mysql -v -u root test -h 127.0.0.1
cat vendor/plaisio/babel-core/lib/ddl/0100_create_tables.sql     | mysql -v -u root test -h 127.0.0.1
cat vendor/plaisio/db-page/lib/ddl/0100_create_tables.sql        | mysql -v -u root test -h 127.0.0.1
cat vendor/plaisio/db-profile/lib/ddl/0100_create_tables.sql     | mysql -v -u root test -h 127.0.0.1
cat vendor/plaisio/db-user/lib/ddl/0100_create_tables.sql        | mysql -v -u root test -h 127.0.0.1
cat vendor/plaisio/authority-core/lib/ddl/0100_create_tables.sql | mysql -v -u root test -h 127.0.0.1
cat vendor/plaisio/core/lib/ddl/0100_create_tables.sql           | mysql -v -u root test -h 127.0.0.1
cat lib/ddl/0100_create_tables.sql                               | mysql -v -u root test -h 127.0.0.1

./bin/stratum -vv stratum test/etc/stratum.ini

./bin/phpunit
