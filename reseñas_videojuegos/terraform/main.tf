provider "azurerm" {
  features {}
}

# Grupo de recursos existente
resource "azurerm_resource_group" "example" {
  name     = "Ira_Nomas"
  location = "Mexico Central"
}

# Crear el plan de servicio actualizado
resource "azurerm_service_plan" "example" {
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
  app_service_plan_id = azurerm_service_plan.example.id

  site_config {
    php_version = "7.4"
  }

  app_settings = {
    DATABASE_URL = "mssql://${azurerm_mssql_server.example.administrator_login}@${azurerm_mssql_server.example.name}.database.windows.net/${azurerm_mssql_database.example.name}?sslmode=required"
  }
}

# Crear el servidor SQL
resource "azurerm_mssql_server" "example" {
  name                         = "iranomasserver"
  location                     = azurerm_resource_group.example.location
  resource_group_name           = azurerm_resource_group.example.name
  administrator_login           = "adminusuario"
  administrator_login_password  = "adminpassword123"
  version                       = "12.0"

  sku {
    name     = "S1"
    tier     = "Standard"
    capacity = 1
  }
}

# Crear la base de datos SQL
resource "azurerm_mssql_database" "example" {
  name                = "videojuegos_db"
  resource_group_name = azurerm_resource_group.example.name
  server_name         = azurerm_mssql_server.example.name
  collation           = "SQL_Latin1_General_CP1_CI_AS"
  max_size_gb         = 5
}

