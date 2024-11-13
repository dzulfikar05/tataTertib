/*
 Navicat Premium Dump SQL

 Source Server         : sqlsrv-local
 Source Server Type    : SQL Server
 Source Server Version : 15002000 (15.00.2000)
 Source Host           : DESKTOP-I0JL8UH\DBMS1:1433
 Source Catalog        : tatatertib
 Source Schema         : Users

 Target Server Type    : SQL Server
 Target Server Version : 15002000 (15.00.2000)
 File Encoding         : 65001

 Date: 09/11/2024 13:46:21
*/
-- Ensure the 'Users' schema exists before creating tables
IF NOT EXISTS (SELECT * FROM sys.schemas WHERE name = 'Users')
BEGIN
    EXEC('CREATE SCHEMA Users');
END
GO

-- ----------------------------
-- Table structure for dosen
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[dosen]') AND type IN ('U'))
BEGIN
    DROP TABLE [Users].[dosen];
END
GO

CREATE TABLE [Users].[dosen] (
    [id] int IDENTITY(1,1) NOT NULL,
    [user_id] int NULL,
    [nidn] varchar(12) NULL,
    [nama] varchar(120) NULL,
    [jk] char(1) NULL,
    [no_hp] varchar(15) NULL,
    [jurusan_id] int NULL
);
GO

-- ----------------------------
-- Records for dosen
-- ----------------------------
SET IDENTITY_INSERT [Users].[dosen] ON;
GO

INSERT INTO [Users].[dosen] ([id], [user_id], [nidn], [nama], [jk], [no_hp], [jurusan_id]) 
VALUES (N'2', N'34', N'1111', N'bagas', N'P', N'234234', N'1');
GO

SET IDENTITY_INSERT [Users].[dosen] OFF;
GO

-- ----------------------------
-- Table structure for mahasiswa
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[mahasiswa]') AND type IN ('U'))
BEGIN
    DROP TABLE [Users].[mahasiswa];
END
GO

CREATE TABLE [Users].[mahasiswa] (
    [id] int IDENTITY(1,1) NOT NULL,
    [user_id] int NULL,
    [nim] varchar(12) NULL,
    [nama] varchar(120) NULL,
    [jk] char(1) NULL,
    [kelas_id] int NULL,
    [no_hp] varchar(15) NULL,
    [poin] int NULL,
    [angkatan] int NULL,
    [status] char(1) NULL
);
GO

-- ----------------------------
-- Records for mahasiswa
-- ----------------------------
SET IDENTITY_INSERT [Users].[mahasiswa] ON;
GO

INSERT INTO [Users].[mahasiswa] ([id], [user_id], [nim], [nama], [jk], [kelas_id], [no_hp], [poin], [angkatan], [status]) 
VALUES (N'1', N'2', N'12345678', N'agus', N'L', N'5', N'087866711494', N'0', N'2023', N'1');
GO

SET IDENTITY_INSERT [Users].[mahasiswa] OFF;
GO

-- ----------------------------
-- Table structure for role
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[role]') AND type IN ('U'))
BEGIN
    DROP TABLE [Users].[role];
END
GO

CREATE TABLE [Users].[role] (
    [id] int IDENTITY(1,1) NOT NULL,
    [name] varchar(32) NULL
);
GO

-- ----------------------------
-- Records for role
-- ----------------------------
SET IDENTITY_INSERT [Users].[role] ON;
GO

INSERT INTO [Users].[role] ([id], [name]) 
VALUES (N'1', N'admin'), 
       (N'2', N'staff'), 
       (N'3', N'dosen'), 
       (N'4', N'mahasiswa');
GO

SET IDENTITY_INSERT [Users].[role] OFF;
GO

-- ----------------------------
-- Table structure for staff
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[staff]') AND type IN ('U'))
BEGIN
    DROP TABLE [Users].[staff];
END
GO

CREATE TABLE [Users].[staff] (
    [id] int IDENTITY(1,1) NOT NULL,
    [user_id] int NULL,
    [nip] varchar(12) NULL,
    [nama] varchar(120) NULL,
    [jk] char(1) NULL,
    [no_hp] varchar(15) NULL,
    [prodi_id] int NULL
);
GO

-- ----------------------------
-- Records for staff
-- ----------------------------
SET IDENTITY_INSERT [Users].[staff] ON;
GO

INSERT INTO [Users].[staff] ([id], [user_id], [nip], [nama], [jk], [no_hp], [prodi_id]) 
VALUES (N'1', N'37', N'Blanditiis', N'Aliquid in velit dol', N'L', N'Consequatur ', N'2');
GO

SET IDENTITY_INSERT [Users].[staff] OFF;
GO

-- ----------------------------
-- Table structure for users
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[users]') AND type IN ('U'))
BEGIN
    DROP TABLE [Users].[users];
END
GO

CREATE TABLE [Users].[users] (
    [id] int IDENTITY(1,1) NOT NULL,
    [username] varchar(32) NULL,
    [password] varchar(255) NULL,
    [role] int NULL,
    [photo_path] text NULL
);
GO

-- ----------------------------
-- Records for users
-- ----------------------------
SET IDENTITY_INSERT [Users].[users] ON;
GO

INSERT INTO [Users].[users] ([id], [username], [password], [role], [photo_path]) 
VALUES (N'1', N'admin', N'$2y$10$D11bdxTgPpX1CHsW.xaGo.f312SzwMJ2VOvpC9zbWOKyI7BLW9sDe', N'1', NULL), 
       (N'2', N'agus', N'$2y$10$D11bdxTgPpX1CHsW.xaGo.f312SzwMJ2VOvpC9zbWOKyI7BLW9sDe', N'4', NULL), 
       (N'34', N'bagas', N'$2y$10$ohvKVNltunNANckcjES5D.atWPthdXeUAwn./OGJZ5hqS9wsi1CAO', N'3', NULL), 
       (N'37', N'xedigadojo232', N'$2y$10$dWqD9uDbU6Auumzb7EqLiOjvbl7FrtqT3pM5vpQ5N5HqBLgSpLuYu', N'2', NULL);
GO

SET IDENTITY_INSERT [Users].[users] OFF;
GO

-- ----------------------------
-- Auto increment value for dosen
-- ----------------------------

-- ----------------------------
-- Checks structure for table dosen
-- ----------------------------
ALTER TABLE [Users].[dosen] ADD CONSTRAINT [CK__dosen__jk__36B12243] CHECK ([jk]='P' OR [jk]='L');
GO

-- ----------------------------
-- Primary Key structure for table dosen
-- ----------------------------
ALTER TABLE [Users].[dosen] ADD CONSTRAINT [PK__dosen__3213E83FBE40240F] PRIMARY KEY CLUSTERED ([id]);
GO

-- ----------------------------
-- Auto increment value for mahasiswa
-- ----------------------------

-- ----------------------------
-- Checks structure for table mahasiswa
-- ----------------------------
ALTER TABLE [Users].[mahasiswa] ADD CONSTRAINT [CK__mahasiswa__jk__31EC6D26] CHECK ([jk]='P' OR [jk]='L');
GO

-- ----------------------------
-- Primary Key structure for table mahasiswa
-- ----------------------------
ALTER TABLE [Users].[mahasiswa] ADD CONSTRAINT [PK__mahasisw__3213E83F1771CE41] PRIMARY KEY CLUSTERED ([id]);
GO

-- ----------------------------
-- Auto increment value for role
-- ----------------------------

-- ----------------------------
-- Primary Key structure for table role
-- ----------------------------
ALTER TABLE [Users].[role] ADD CONSTRAINT [PK__role__3213E83FE43097A7] PRIMARY KEY CLUSTERED ([id]);
GO

-- ----------------------------
-- Auto increment value for staff
-- ----------------------------

-- ----------------------------
-- Checks structure for table staff
-- ----------------------------
ALTER TABLE [Users].[staff] ADD CONSTRAINT [CK__staff_keaman__jk__3A81B327] CHECK ([jk]='P' OR [jk]='L');
GO

-- ----------------------------
-- Primary Key structure for table staff
-- ----------------------------
ALTER TABLE [Users].[staff] ADD CONSTRAINT [PK__staff_ke__3213E83F0AD87B3C] PRIMARY KEY CLUSTERED ([id]);
GO

-- ----------------------------
-- Auto increment value for users
-- ----------------------------