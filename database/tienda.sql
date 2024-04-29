use tienda
GO
CREATE TABLE Productos(
    id_Producto INTEGER IDENTITY NOT NULL,
    producto VARCHAR(120) NOT NULL
)
GO
INSERT INTO Productos (producto) VALUES('Cocacola 600ml');