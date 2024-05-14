create database Abarrotera;
use Abarrotera;

CREATE TABLE Personas(
    idPersona int NOT NULL identity,
    Nombre VARCHAR (100) not NULL,
    Paterno VARCHAR (50) NOT NULL,
    Materno VARCHAR (50) NOT NULL,
    Sexo VARCHAR (1) NOT NULL check(sexo in ('M','F','NU')),
    Direccion VARCHAR (100) NOT NULL,
    Telefono VARCHAR (10),
    Curp VARCHAR (18) NOT NULL,
    RFC VARCHAR (13) UNIQUE,
    constraint PK_idPersona PRIMARY KEY (idPersona),
    constraint UQ_Curp UNIQUE (CURP),
    constraint UQ_RFC UNIQUE (RFC)
)

CREATE TABLE Horarios(
    idHorario int NOT NULL identity,
    Horario VARCHAR (15) NOT NULL,
    constraint PK_idHorario PRIMARY KEY(idHorario)
)

create table Puestos(
	idPuesto int not null,
	Puesto varchar (30) not null,
	constraint PK_idPuesto primary key (idPuesto)
)

CREATE TABLE Empleados(
    idEmpleado int NOT NULL identity,
    idPersona INT NOT NULL,
    Sueldo money NOT NULL check (Sueldo >=0),
    idPuesto INT NOT NULL,
	idHorario int not null,
    constraint PK_idEmpleado PRIMARY KEY (idEmpleado),
    constraint FK_EmpleadosPersonas FOREIGN KEY (idPersona) REFERENCES Personas(idPersona),
    constraint FK_EmpleadosHorarios FOREIGN KEY (idHorario) REFERENCES Horarios(idHorario),
    constraint FK_EmpleadosPuestos FOREIGN KEY (idPuesto) REFERENCES Puestos(idPuesto)
)

CREATE TABLE Proveedores(
    idProveedor int NOT NULL identity,
    idPersona INT NOT NULL,
    Empresa VARCHAR (100) NOT NULL,
    constraint idProveedor PRIMARY KEY (idProveedor),
    constraint FK_ProveedoresPersonas FOREIGN KEY (idPersona) REFERENCES Personas(idPersona)
)

CREATE TABLE Clientes(
    idCliente int NOT NULL identity,
    idPersona int,
    Credito money check(Credito >= 0 and Credito <=10000),
    constraint idCliente PRIMARY KEY (idCliente),
    constraint FK_ClientesPersonas FOREIGN KEY (idPersona) REFERENCES Personas(idPersona)
)

CREATE TABLE Categorias(
    idCategoria INT NOT NULL identity,
    Categoria VARCHAR (50) NOT NULL,
    Refrogeracion BIT 
    constraint PK_idCategoria PRIMARY KEY (idCategoria),

)

CREATE TABLE Productos(
    idProducto int NOT NULL identity,
    Producto VARCHAR (100) NOT NULL,
    Caducidad DATE NOT NULL,
    Lote VARCHAR (20) NOT NULL,
    idProveedor INT NOT NULL,
    idCategoria INT NOT NULL,
    constraint idProducto PRIMARY KEY (idProducto),
    constraint FK_ProductosProveedores FOREIGN KEY (idProveedor) REFERENCES Proveedores(idProveedor),
    constraint FK_ProductosCategorias FOREIGN KEY (idCategoria) REFERENCES Categorias(idCategoria)
    )

CREATE TABLE Ventas(
    idVenta INT NOT NULL identity,
    Monto Money not NULL,
    Fecha DATE NOT NULL, 
    constraint idVenta PRIMARY KEY (idVenta)
)

CREATE Table Almacenes(
    idAlmacen INT NOT NULL identity,
    Almacen VARCHAR (40),
	constraint idAlmacen primary Key (idAlmacen)
)

CREATE TABLE Sucursales(
    idSucursal int not null IDENTITY,
    Sucursal varchar(50) not null,
    constraint idSucursal PRIMARY KEY (idSucursal)
)

CREATE TABLE DetalleVenta(
    idDetalleVenta INT NOT NULL identity,
    Cantidad int NOT NULL,
    Total INT NOT NULL,
    Descripcion VARCHAR (50),
    idProducto int not null,
    idAlmacen int not null,
    idSucursal int not null,
    constraint idDetalleVenta PRIMARY KEY (idDetalleVenta), 
    constraint FK_VentaProducto FOREIGN KEY (idProducto) REFERENCES Productos(idProducto),
    constraint FK_AlmacenProducto FOREIGN KEY (idAlmacen) REFERENCES Almacenes(idAlmacen),
    constraint FK_SucursalProducto FOREIGN KEY (idSucursal) REFERENCES Sucursales(idSucursal)
)