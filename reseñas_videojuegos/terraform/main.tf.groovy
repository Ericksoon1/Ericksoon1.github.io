provider "azurerm" {
  features {}
}

# Grupo de recursos ya existente
resource "azurerm_resource_group" "example" {
  name     = "Ira_Nomas"
  location = "Mexico Central"
}

# Crear el plan de App Service
resource "azurerm_app_service_plan" "example" {
  name                = "mi-plan-appservice"
  location            = azurerm_resource_group.example.location
  resource_group_name = azurerm_resource_group.example.name
  sku {
    tier = "Basic"
    size = "B1"
  }
}

# Crear el App Service
resource "azurerm_app_service" "example" {
  name                = "mi-app-service"
  location            = azurerm_resource_group.example.location
  resource_group_name = azurerm_resource_group.example.name
  app_service_plan_id = azurerm_app_service_plan.example.id

  site_config {
    php_version = "7.4"
  }

  app_settings = {
    DATABASE_URL = "mysql://${azurerm_mysql_server.example.administrator_login}@${azurerm_mysql_server.example.name}.mysql.database.azure.com/${azurerm_mysql_database.example.name}?sslmode=required"
  }
}

# Servidor MySQL ya existente
resource "azurerm_mysql_server" "example" {
  name                = "iranomasserver"
  location            = azurerm_resource_group.example.location
  resource_group_name = azurerm_resource_group.example.name
  administrator_login = "adminusuario"
  administrator_login_password = "adminpassword123"

  sku {
    name   = "B_Gen5_1"
    tier   = "Basic"
    family = "Gen5"
    capacity = 1
  }

  storage_profile {
    storage_mb = 5120
    backup_retention_days = 7
    geo_redundant_backup = "Disabled"
  }
}

# Base de datos MySQL ya existente
resource "azurerm_mysql_database" "example" {
  name                = "videojuegos_db"
  resource_group_name = azurerm_resource_group.example.name
  server_name         = azurerm_mysql_server.example.name
  charset             = "utf8"
  collation           = "utf8_general_ci"
}
