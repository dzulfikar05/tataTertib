/*
 Navicat Premium Dump SQL

 Source Server         : sqlsrv-local
 Source Server Type    : SQL Server
 Source Server Version : 15002000 (15.00.2000)
 Source Host           : DESKTOP-I0JL8UH\DBMS1:1433
 Source Catalog        : tatatertib
 Source Schema         : Pelanggaran

 Target Server Type    : SQL Server
 Target Server Version : 15002000 (15.00.2000)
 File Encoding         : 65001

 Date: 09/11/2024 13:45:30
*/


-- ----------------------------
-- Table structure for kategori
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Pelanggaran].[kategori]') AND type IN ('U'))
	DROP TABLE [Pelanggaran].[kategori]
GO

CREATE TABLE [Pelanggaran].[kategori] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [nama] varchar(200) NULL,
  [keterangan] text NULL,
  [bobot] int  NULL
)
GO

ALTER TABLE [Pelanggaran].[kategori] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of kategori
-- ----------------------------
SET IDENTITY_INSERT [Pelanggaran].[kategori] ON
GO

SET IDENTITY_INSERT [Pelanggaran].[kategori] OFF
GO


-- ----------------------------
-- Table structure for pelanggaran
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Pelanggaran].[pelanggaran]') AND type IN ('U'))
	DROP TABLE [Pelanggaran].[pelanggaran]
GO

CREATE TABLE [Pelanggaran].[pelanggaran] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [tanggal] date  NULL,
  [kategori_id] int  NULL,
  [pelaku_id] int  NULL,
  [pelapor_id] int  NULL,
  [keterangan] text NULL,
  [verify_by] int  NULL,
  [verify_at] datetime  NULL,
  [status] char(1) NULL
)
GO

ALTER TABLE [Pelanggaran].[pelanggaran] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of pelanggaran
-- ----------------------------
SET IDENTITY_INSERT [Pelanggaran].[pelanggaran] ON
GO

SET IDENTITY_INSERT [Pelanggaran].[pelanggaran] OFF
GO


-- ----------------------------
-- Table structure for sanksi
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Pelanggaran].[sanksi]') AND type IN ('U'))
	DROP TABLE [Pelanggaran].[sanksi]
GO

CREATE TABLE [Pelanggaran].[sanksi] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [pelanggaran_id] int  NULL,
  [tugas] varchar(180) NULL,
  [keterangan] text NULL,
  [verify_by] int  NULL,
  [status] char(1) NULL,
  [catatan] text NULL
)
GO

ALTER TABLE [Pelanggaran].[sanksi] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of sanksi
-- ----------------------------
SET IDENTITY_INSERT [Pelanggaran].[sanksi] ON
GO

SET IDENTITY_INSERT [Pelanggaran].[sanksi] OFF
GO


-- ----------------------------
-- Auto increment value for kategori
-- ----------------------------
DBCC CHECKIDENT ('[Pelanggaran].[kategori]', RESEED, 1)
GO


-- ----------------------------
-- Primary Key structure for table kategori
-- ----------------------------
ALTER TABLE [Pelanggaran].[kategori] ADD CONSTRAINT [PK__kategori__3213E83F7BB0B50E] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for pelanggaran
-- ----------------------------
DBCC CHECKIDENT ('[Pelanggaran].[pelanggaran]', RESEED, 1)
GO


-- ----------------------------
-- Primary Key structure for table pelanggaran
-- ----------------------------
ALTER TABLE [Pelanggaran].[pelanggaran] ADD CONSTRAINT [PK__pelangga__3213E83F0A325B4A] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for sanksi
-- ----------------------------
DBCC CHECKIDENT ('[Pelanggaran].[sanksi]', RESEED, 1)
GO


-- ----------------------------
-- Primary Key structure for table sanksi
-- ----------------------------
ALTER TABLE [Pelanggaran].[sanksi] ADD CONSTRAINT [PK__sanksi__3213E83F28E3B518] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Foreign Keys structure for table pelanggaran
-- ----------------------------
ALTER TABLE [Pelanggaran].[pelanggaran] ADD CONSTRAINT [FK__pelanggar__statu__403A8C7D] FOREIGN KEY ([kategori_id]) REFERENCES [Pelanggaran].[kategori] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [Pelanggaran].[pelanggaran] ADD CONSTRAINT [FK__pelanggar__pelak__412EB0B6] FOREIGN KEY ([pelaku_id]) REFERENCES [Users].[users] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [Pelanggaran].[pelanggaran] ADD CONSTRAINT [FK__pelanggar__pelap__4222D4EF] FOREIGN KEY ([pelapor_id]) REFERENCES [Users].[users] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [Pelanggaran].[pelanggaran] ADD CONSTRAINT [FK__pelanggar__verif__4316F928] FOREIGN KEY ([verify_by]) REFERENCES [Users].[users] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table sanksi
-- ----------------------------
ALTER TABLE [Pelanggaran].[sanksi] ADD CONSTRAINT [FK__sanksi__pelangga__45F365D3] FOREIGN KEY ([pelanggaran_id]) REFERENCES [Pelanggaran].[pelanggaran] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

