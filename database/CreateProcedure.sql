-- utils
-- CREATE PROCEDURE sp_GetAll
--     @table NVARCHAR(32)
-- AS
-- BEGIN
--     SET NOCOUNT ON;

--     DECLARE @sql NVARCHAR(MAX);
--     SET @sql = 'SELECT * FROM ' + QUOTENAME(@table);

--     EXEC sp_executesql @sql;
-- END;
-- GO

-- CREATE PROCEDURE sp_GetBy
--     @table NVARCHAR(32),
--     @column NVARCHAR(32),
--     @id INT
-- AS
-- BEGIN
--     SET NOCOUNT ON;

--     DECLARE @sql NVARCHAR(MAX);
--     SET @sql = 'SELECT * FROM ' + QUOTENAME(@table) + ' WHERE ' + QUOTENAME(@column) + ' = @idParam';
--     PRINT @sql;
    
--     EXEC sp_executesql @sql, N'@idParam INT', @id;
-- END;
-- GO


-- CREATE PROCEDURE sp_InsertData
--     @table NVARCHAR(128),
--     @columns NVARCHAR(MAX),
--     @values NVARCHAR(MAX)
-- AS
-- BEGIN
--     SET NOCOUNT ON;

--     DECLARE @sql NVARCHAR(MAX);
    
--     -- Membangun query dinamis INSERT INTO
--     SET @sql = N'INSERT INTO ' + QUOTENAME(@table) + ' (' + @columns + ') VALUES (' + @values + ')';

--     -- Eksekusi query
--     EXEC sp_executesql @sql;
-- END;
-- GO




-- Akademik.jurusan
CREATE PROCEDURE sp_InsertJurusan
    @nama NVARCHAR(32)
AS
BEGIN
    SET NOCOUNT ON;

    INSERT INTO Akademik.jurusan (nama)
    VALUES (@nama);
END;
GO

CREATE PROCEDURE sp_UpdateJurusan
    @id INT,
    @nama NVARCHAR(32)
AS
BEGIN
    SET NOCOUNT ON;

    UPDATE Akademik.jurusan
    SET nama = @nama
    WHERE id = @id;
END;
GO

-- how to run 
EXEC sp_InsertJurusan 
    @nama = 'Teknik Man United';

EXEC sp_UpdateJurusan 
    @id = 1, 
    @nama = 'GGMU';

-- to drop
DROP PROCEDURE sp_InsertJurusan

