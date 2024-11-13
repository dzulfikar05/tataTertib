/*
 Navicat Premium Dump SQL

 Source Server         : sqlsrv-local
 Source Server Type    : SQL Server
 Source Server Version : 15002000 (15.00.2000)
 Source Host           : DESKTOP-I0JL8UH\DBMS1:1433
 Source Catalog        : tatatertib
 Source Schema         : Akademik

 Target Server Type    : SQL Server
 Target Server Version : 15002000 (15.00.2000)
 File Encoding         : 65001

 Date: 09/11/2024 13:44:41
*/

-- Jika Anda perlu membuat schema, dan tidak yakin apakah sudah ada, gunakan ini:
IF NOT EXISTS (SELECT * FROM sys.schemas WHERE name = 'Akademik')
BEGIN
    EXEC ('CREATE SCHEMA Akademik');
END
GO

-- ----------------------------
-- Table structure for jurusan
-- ----------------------------
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[Akademik].[jurusan]') AND type = 'U')
BEGIN
    DROP TABLE [Akademik].[jurusan];
END
GO

CREATE TABLE [Akademik].[jurusan] (
  [id] int IDENTITY(1,1) NOT NULL,
  [nama] varchar(32) NULL
);
GO

ALTER TABLE [Akademik].[jurusan] SET (LOCK_ESCALATION = TABLE);
GO

-- ----------------------------
-- Records of jurusan
-- ----------------------------
SET IDENTITY_INSERT [Akademik].[jurusan] ON;
GO

INSERT INTO [Akademik].[jurusan] ([id], [nama]) VALUES (1, N'Teknologi Informasi');
GO

INSERT INTO [Akademik].[jurusan] ([id], [nama]) VALUES (5, N'Teknik Mesin');
GO

INSERT INTO [Akademik].[jurusan] ([id], [nama]) VALUES (6, N'Teknik Kimia');
GO

SET IDENTITY_INSERT [Akademik].[jurusan] OFF;
GO

-- ----------------------------
-- Table structure for kelas
-- ----------------------------
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[Akademik].[kelas]') AND type = 'U')
BEGIN
    DROP TABLE [Akademik].[kelas];
END
GO

CREATE TABLE [Akademik].[kelas] (
  [id] int IDENTITY(1,1) NOT NULL,
  [nama] varchar(32) NULL,
  [prodi_id] int NULL
);
GO

ALTER TABLE [Akademik].[kelas] SET (LOCK_ESCALATION = TABLE);
GO

-- ----------------------------
-- Records of kelas
-- ----------------------------
SET IDENTITY_INSERT [Akademik].[kelas] ON;
GO

INSERT INTO [Akademik].[kelas] ([id], [nama], [prodi_id]) VALUES (2, N'1B', 1);
GO

INSERT INTO [Akademik].[kelas] ([id], [nama], [prodi_id]) VALUES (3, N'1C', 1);
GO

INSERT INTO [Akademik].[kelas] ([id], [nama], [prodi_id]) VALUES (4, N'1A', 2);
GO

INSERT INTO [Akademik].[kelas] ([id], [nama], [prodi_id]) VALUES (5, N'1B', 2);
GO

INSERT INTO [Akademik].[kelas] ([id], [nama], [prodi_id]) VALUES (6, N'1C', 2);
GO

INSERT INTO [Akademik].[kelas] ([id], [nama], [prodi_id]) VALUES (8, N'Kelas Man United', 1);
GO

SET IDENTITY_INSERT [Akademik].[kelas] OFF;
GO

-- ----------------------------
-- Table structure for prodi
-- ----------------------------
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[Akademik].[prodi]') AND type = 'U')
BEGIN
    DROP TABLE [Akademik].[prodi];
END
GO

CREATE TABLE [Akademik].[prodi] (
  [id] int IDENTITY(1,1) NOT NULL,
  [nama] varchar(32) NULL,
  [jurusan_id] int NULL
);
GO

ALTER TABLE [Akademik].[prodi] SET (LOCK_ESCALATION = TABLE);
GO

-- ----------------------------
-- Records of prodi
-- ----------------------------
SET IDENTITY_INSERT [Akademik].[prodi] ON;
GO

INSERT INTO [Akademik].[prodi] ([id], [nama], [jurusan_id]) VALUES (1, N'DIV Teknik Informatika', 1);
GO

INSERT INTO [Akademik].[prodi] ([id], [nama], [jurusan_id]) VALUES (2, N'DIV Sistem Informasi Bisnis', 1);
GO

SET IDENTITY_INSERT [Akademik].[prodi] OFF;
GO

-- ----------------------------
-- View structure for v_kelas
-- ----------------------------
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[Akademik].[v_kelas]') AND type = 'V')
BEGIN
    DROP VIEW [Akademik].[v_kelas];
END
GO

CREATE VIEW [Akademik].[v_kelas] AS 
SELECT
    kelas.id,
    kelas.nama, 
    kelas.prodi_id, 
    prodi.nama as prodi_nama, 
    prodi.jurusan_id, 
    jurusan.nama as jurusan_nama
FROM
    Akademik.kelas
    LEFT JOIN
    Akademik.prodi
    ON kelas.prodi_id = prodi.id
    LEFT JOIN
    Akademik.jurusan
    ON prodi.jurusan_id = jurusan.id;
GO

-- ----------------------------
-- View structure for v_prodi
-- ----------------------------
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[Akademik].[v_prodi]') AND type = 'V')
BEGIN
    DROP VIEW [Akademik].[v_prodi];
END
GO

CREATE VIEW [Akademik].[v_prodi] AS 
SELECT
    prodi.id, 
    prodi.nama, 
    prodi.jurusan_id, 
    jurusan.nama as jurusan_nama
FROM
    Akademik.prodi
    LEFT JOIN
    Akademik.jurusan
    ON prodi.jurusan_id = jurusan.id;
GO

-- ----------------------------
-- Auto increment value for jurusan
-- ----------------------------
DBCC CHECKIDENT ('[Akademik].[jurusan]', RESEED, 7);
GO

-- ----------------------------
-- Primary Key structure for table jurusan
-- ----------------------------
ALTER TABLE [Akademik].[jurusan] 
ADD CONSTRAINT [PK__jurusan__3213E83F40C93C67] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY];
GO

-- ----------------------------
-- Auto increment value for kelas
-- ----------------------------
DBCC CHECKIDENT ('[Akademik].[kelas]', RESEED, 8);
GO

-- ----------------------------
-- Primary Key structure for table kelas
-- ----------------------------
ALTER TABLE [Akademik].[kelas] 
ADD CONSTRAINT [PK__kelas__3213E83FFE8FAD73] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY];
GO

-- ----------------------------
-- Auto increment value for prodi
-- ----------------------------
DBCC CHECKIDENT ('[Akademik].[prodi]', RESEED, 3);
GO

-- ----------------------------
-- Primary Key structure for table prodi
-- ----------------------------
ALTER TABLE [Akademik].[prodi] 
ADD CONSTRAINT [PK__prodi__3213E83F7D053296] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY];
GO

-- ----------------------------
-- Foreign Keys structure for table kelas
-- ----------------------------
ALTER TABLE [Akademik].[kelas] 
ADD CONSTRAINT [FK__kelas__prodi_id__2F10007B] FOREIGN KEY ([prodi_id]) REFERENCES [Akademik].[prodi] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION;
GO

-- ----------------------------
-- Foreign Keys structure for table prodi
-- ----------------------------
ALTER TABLE [Akademik].[prodi] 
ADD CONSTRAINT [FK__prodi__jurusan_i__2C3393D0] FOREIGN KEY ([jurusan_id]) REFERENCES [Akademik].[jurusan] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION;
GO
