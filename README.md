# boundary_waters_entry_point_alerter
To get db running, need to add this config to .env file. Fill in variables.
# MySQL Configuration
MYSQL_VERSION=8.0.41
MYSQL_DATABASE=
MYSQL_USER=
MYSQL_PASSWORD=
MYSQL_ROOT_PASSWORD=

# Database URL for Doctrine
DATABASE_URL="mysql://${MYSQL_USER:-app}:${MYSQL_PASSWORD}@127.0.0.1:3307/${MYSQL_DATABASE:-app}?serverVersion=8.0.32&charset=utf8mb4"
