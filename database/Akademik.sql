-- Pastikan skema Akademik ada
IF NOT EXISTS (SELECT * FROM sys.schemas WHERE name = 'Akademik')
BEGIN
    EXEC('CREATE SCHEMA [Akademik]')
END
GO

-- ----------------------------
-- Table structure for jurusan
-- ----------------------------
IF OBJECT_ID('[Akademik].[jurusan]', 'U') IS NOT NULL
    DROP TABLE [Akademik].[jurusan]
GO

CREATE TABLE [Akademik].[jurusan] (
  [id] INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
  [nama] VARCHAR(32) NULL
)
GO

-- Records of jurusan
INSERT INTO [Akademik].[jurusan] ([nama]) 
VALUES 
(N'Teknologi Informasi'),
(N'Teknik Mesin'),
(N'Teknik Kimia')
GO

-- ----------------------------
-- Table structure for prodi
-- ----------------------------
IF OBJECT_ID('[Akademik].[prodi]', 'U') IS NOT NULL
    DROP TABLE [Akademik].[prodi]
GO

CREATE TABLE [Akademik].[prodi] (
  [id] INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
  [nama] VARCHAR(32) NULL,
  [jurusan_id] INT NOT NULL FOREIGN KEY REFERENCES [Akademik].[jurusan]([id])
)
GO

-- Records of prodi
INSERT INTO [Akademik].[prodi] ([nama], [jurusan_id]) 
VALUES 
(N'DIV Teknik Informatika', 1),
(N'DIV Sistem Informasi Bisnis', 1)
GO

-- ----------------------------
-- Table structure for kelas
-- ----------------------------
IF OBJECT_ID('[Akademik].[kelas]', 'U') IS NOT NULL
    DROP TABLE [Akademik].[kelas]
GO

CREATE TABLE [Akademik].[kelas] (
  [id] INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
  [nama] VARCHAR(32) NULL,
  [prodi_id] INT NOT NULL FOREIGN KEY REFERENCES [Akademik].[prodi]([id])
)
GO

-- Records of kelas
INSERT INTO [Akademik].[kelas] ([nama], [prodi_id]) 
VALUES 
(N'TI 1B', 1),
(N'TI 1C', 1),
(N'SIB 1A', 2),
(N'SIB 1B', 2),
(N'SIB 1C', 2)
GO

-- ----------------------------
-- View structure for v_kelas
-- ----------------------------
IF OBJECT_ID('[Akademik].[v_kelas]', 'V') IS NOT NULL
    DROP VIEW [Akademik].[v_kelas]
GO

CREATE VIEW [Akademik].[v_kelas] AS
SELECT 
  kelas.id,
  kelas.nama,
  kelas.prodi_id,
  prodi.nama AS prodi_nama,
  prodi.jurusan_id,
  jurusan.nama AS jurusan_nama
FROM [Akademik].[kelas]
LEFT JOIN [Akademik].[prodi] ON kelas.prodi_id = prodi.id
LEFT JOIN [Akademik].[jurusan] ON prodi.jurusan_id = jurusan.id
GO

-- ----------------------------
-- View structure for v_prodi
-- ----------------------------
IF OBJECT_ID('[Akademik].[v_prodi]', 'V') IS NOT NULL
    DROP VIEW [Akademik].[v_prodi]
GO

CREATE VIEW [Akademik].[v_prodi] AS
SELECT 
  prodi.id,
  prodi.nama,
  prodi.jurusan_id,
  jurusan.nama AS jurusan_nama
FROM [Akademik].[prodi]
LEFT JOIN [Akademik].[jurusan] ON prodi.jurusan_id = jurusan.id
GO

-- ----------------------------
-- Reset Identity Values (Optional)
-- ----------------------------
DBCC CHECKIDENT ('[Akademik].[jurusan]', RESEED, 9)
GO
DBCC CHECKIDENT ('[Akademik].[prodi]', RESEED, 4)
GO
DBCC CHECKIDENT ('[Akademik].[kelas]', RESEED, 9)
GO
