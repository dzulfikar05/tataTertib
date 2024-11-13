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

