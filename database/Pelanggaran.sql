/*
 Navicat Premium Dump SQL

 Source Server         : sqlsrv-local
 Source Server Type    : SQL Server
 Source Server Version : 15002000 (15.00.2000)
 Source Host           : DESKTOP-I0JL8UH\DBMS1:1433
 Source Catalog        : tataTertibNew
 Source Schema         : Pelanggaran

 Target Server Type    : SQL Server
 Target Server Version : 15002000 (15.00.2000)
 File Encoding         : 65001

 Date: 13/11/2024 20:41:35
*/
-- Pastikan schema 'Pelanggaran' ada
IF NOT EXISTS (SELECT * FROM sys.schemas WHERE name = 'Pelanggaran')
BEGIN
    EXEC ('CREATE SCHEMA Pelanggaran');
END
GO


-- ----------------------------
-- Drop Foreign Keys di tabel 'pelanggaran' jika ada
-- ----------------------------

IF EXISTS (SELECT * FROM sys.foreign_keys WHERE parent_object_id = OBJECT_ID(N'[Pelanggaran].[pelanggaran]') AND name = 'FK__pelanggar__statu__403A8C7D')
BEGIN
    ALTER TABLE [Pelanggaran].[pelanggaran] DROP CONSTRAINT [FK__pelanggar__statu__403A8C7D];
END
GO

IF EXISTS (SELECT * FROM sys.foreign_keys WHERE parent_object_id = OBJECT_ID(N'[Pelanggaran].[pelanggaran]') AND name = 'FK__pelanggar__pelak__412EB0B6')
BEGIN
    ALTER TABLE [Pelanggaran].[pelanggaran] DROP CONSTRAINT [FK__pelanggar__pelak__412EB0B6];
END
GO

IF EXISTS (SELECT * FROM sys.foreign_keys WHERE parent_object_id = OBJECT_ID(N'[Pelanggaran].[pelanggaran]') AND name = 'FK__pelanggar__pelap__4222D4EF')
BEGIN
    ALTER TABLE [Pelanggaran].[pelanggaran] DROP CONSTRAINT [FK__pelanggar__pelap__4222D4EF];
END
GO

IF EXISTS (SELECT * FROM sys.foreign_keys WHERE parent_object_id = OBJECT_ID(N'[Pelanggaran].[pelanggaran]') AND name = 'FK__pelanggar__verif__4316F928')
BEGIN
    ALTER TABLE [Pelanggaran].[pelanggaran] DROP CONSTRAINT [FK__pelanggar__verif__4316F928];
END
GO

-- Hapus Foreign Key pada tabel 'sanksi' yang mengacu ke tabel 'pelanggaran'
IF EXISTS (SELECT * FROM sys.foreign_keys WHERE parent_object_id = OBJECT_ID(N'[Pelanggaran].[sanksi]') AND name = 'FK__sanksi__pelangga__45F365D3')
BEGIN
    ALTER TABLE [Pelanggaran].[sanksi] DROP CONSTRAINT [FK__sanksi__pelangga__45F365D3];
END
GO

-- ----------------------------
-- Hapus tabel yang ada sebelum membuat tabel baru
-- ----------------------------

-- Drop tabel 'pelanggaran' jika ada
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Pelanggaran].[pelanggaran]') AND type IN ('U'))
BEGIN
    DROP TABLE [Pelanggaran].[pelanggaran];
END
GO

-- Drop tabel 'kategori' jika ada
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Pelanggaran].[kategori]') AND type IN ('U'))
BEGIN
    DROP TABLE [Pelanggaran].[kategori];
END
GO

-- Drop tabel 'sanksi' jika ada
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Pelanggaran].[sanksi]') AND type IN ('U'))
BEGIN
    DROP TABLE [Pelanggaran].[sanksi];
END
GO

-- ----------------------------
-- Buat tabel 'kategori' baru
-- ----------------------------

CREATE TABLE [Pelanggaran].[kategori] (
  [id] int IDENTITY(1,1) NOT NULL,
  [nama] varchar(200) NULL,
  [keterangan] text NULL,
  [bobot] int NULL,
  CONSTRAINT [PK__kategori__3213E83F7BB0B50E] PRIMARY KEY CLUSTERED ([id])
);
GO

-- ----------------------------
-- Buat tabel 'pelanggaran' baru
-- ----------------------------

CREATE TABLE [Pelanggaran].[pelanggaran] (
  [id] int IDENTITY(1,1) NOT NULL,
  [tanggal] date NULL,
  [kategori_id] int NULL,
  [pelaku_id] int NULL,
  [pelapor_id] int NULL,
  [keterangan] text NULL,
  [verify_by] int NULL,
  [verify_at] datetime NULL,
  [status] char(1) NULL,
  CONSTRAINT [PK__pelangga__3213E83F0A325B4A] PRIMARY KEY CLUSTERED ([id])
);
GO

-- ----------------------------
-- Buat tabel 'sanksi' baru
-- ----------------------------

CREATE TABLE [Pelanggaran].[sanksi] (
  [id] int IDENTITY(1,1) NOT NULL,
  [pelanggaran_id] int NULL,
  [tugas] varchar(180) NULL,
  [keterangan] text NULL,
  [verify_by] int NULL,
  [status] char(1) NULL,
  [catatan] text NULL,
  [updated_at] datetime NULL,
  CONSTRAINT [PK__sanksi__3213E83F28E3B518] PRIMARY KEY CLUSTERED ([id])
);
GO

-- ----------------------------
-- Buat kembali Foreign Key di tabel 'pelanggaran' yang mengacu ke tabel 'kategori'
-- ----------------------------

ALTER TABLE [Pelanggaran].[pelanggaran] 
ADD CONSTRAINT [FK__pelanggar__statu__403A8C7D] 
FOREIGN KEY ([kategori_id]) 
REFERENCES [Pelanggaran].[kategori] ([id]) 
ON DELETE NO ACTION 
ON UPDATE NO ACTION;
GO

-- ----------------------------
-- Buat Foreign Key pada tabel 'sanksi' yang mengacu ke tabel 'pelanggaran'
-- ----------------------------

ALTER TABLE [Pelanggaran].[sanksi] 
ADD CONSTRAINT [FK__sanksi__pelangga__45F365D3] 
FOREIGN KEY ([pelanggaran_id]) 
REFERENCES [Pelanggaran].[pelanggaran] ([id]) 
ON DELETE NO ACTION 
ON UPDATE NO ACTION;
GO
