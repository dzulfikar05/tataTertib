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


-- ----------------------------
-- Table structure for dosen
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[dosen]') AND type IN ('U'))
	DROP TABLE [Users].[dosen]
GO

CREATE TABLE [Users].[dosen] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [user_id] int  NULL,
  [nidn] varchar(12)  NULL,
  [nama] varchar(120)  NULL,
  [jk] char(1)  NULL,
  [no_hp] varchar(15)  NULL,
  [jurusan_id] int  NULL
)
GO

ALTER TABLE [Users].[dosen] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of dosen
-- ----------------------------
SET IDENTITY_INSERT [Users].[dosen] ON
GO

INSERT INTO [Users].[dosen] ([id], [user_id], [nidn], [nama], [jk], [no_hp], [jurusan_id]) VALUES (N'2', N'34', N'1111', N'bagas', N'P', N'234234', N'1')
GO

SET IDENTITY_INSERT [Users].[dosen] OFF
GO


-- ----------------------------
-- Table structure for mahasiswa
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[mahasiswa]') AND type IN ('U'))
	DROP TABLE [Users].[mahasiswa]
GO

CREATE TABLE [Users].[mahasiswa] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [user_id] int  NULL,
  [nim] varchar(12)  NULL,
  [nama] varchar(120)  NULL,
  [jk] char(1)  NULL,
  [kelas_id] int  NULL,
  [no_hp] varchar(15)  NULL,
  [poin] int  NULL,
  [angkatan] int  NULL,
  [status] char(1)  NULL
)
GO

ALTER TABLE [Users].[mahasiswa] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of mahasiswa
-- ----------------------------
SET IDENTITY_INSERT [Users].[mahasiswa] ON
GO

INSERT INTO [Users].[mahasiswa] ([id], [user_id], [nim], [nama], [jk], [kelas_id], [no_hp], [poin], [angkatan], [status]) VALUES (N'1', N'2', N'12345678', N'agus', N'L', N'5', N'087866711494', N'0', N'2023', N'1')
GO

SET IDENTITY_INSERT [Users].[mahasiswa] OFF
GO


-- ----------------------------
-- Table structure for role
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[role]') AND type IN ('U'))
	DROP TABLE [Users].[role]
GO

CREATE TABLE [Users].[role] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [name] varchar(32)  NULL
)
GO

ALTER TABLE [Users].[role] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of role
-- ----------------------------
SET IDENTITY_INSERT [Users].[role] ON
GO

INSERT INTO [Users].[role] ([id], [name]) VALUES (N'1', N'admin')
GO

INSERT INTO [Users].[role] ([id], [name]) VALUES (N'2', N'staff')
GO

INSERT INTO [Users].[role] ([id], [name]) VALUES (N'3', N'dosen')
GO

INSERT INTO [Users].[role] ([id], [name]) VALUES (N'4', N'mahasiswa')
GO

SET IDENTITY_INSERT [Users].[role] OFF
GO


-- ----------------------------
-- Table structure for staff
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[staff]') AND type IN ('U'))
	DROP TABLE [Users].[staff]
GO

CREATE TABLE [Users].[staff] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [user_id] int  NULL,
  [nip] varchar(12)  NULL,
  [nama] varchar(120)  NULL,
  [jk] char(1)  NULL,
  [no_hp] varchar(15)  NULL,
  [prodi_id] int  NULL
)
GO

ALTER TABLE [Users].[staff] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of staff
-- ----------------------------
SET IDENTITY_INSERT [Users].[staff] ON
GO

INSERT INTO [Users].[staff] ([id], [user_id], [nip], [nama], [jk], [no_hp], [prodi_id]) VALUES (N'1', N'37', N'Blanditiis', N'Aliquid in velit dol', N'L', N'Consequatur ', N'2')
GO

SET IDENTITY_INSERT [Users].[staff] OFF
GO


-- ----------------------------
-- Table structure for users
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[users]') AND type IN ('U'))
	DROP TABLE [Users].[users]
GO

CREATE TABLE [Users].[users] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [username] varchar(32)  NULL,
  [password] varchar(255)  NULL,
  [role] int  NULL,
  [photo_path] text  NULL
)
GO

ALTER TABLE [Users].[users] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of users
-- ----------------------------
SET IDENTITY_INSERT [Users].[users] ON
GO

INSERT INTO [Users].[users] ([id], [username], [password], [role], [photo_path]) VALUES (N'1', N'admin', N'$2y$10$D11bdxTgPpX1CHsW.xaGo.f312SzwMJ2VOvpC9zbWOKyI7BLW9sDe', N'1', NULL)
GO

INSERT INTO [Users].[users] ([id], [username], [password], [role], [photo_path]) VALUES (N'2', N'agus', N'$2y$10$D11bdxTgPpX1CHsW.xaGo.f312SzwMJ2VOvpC9zbWOKyI7BLW9sDe', N'4', NULL)
GO

INSERT INTO [Users].[users] ([id], [username], [password], [role], [photo_path]) VALUES (N'34', N'bagas', N'$2y$10$ohvKVNltunNANckcjES5D.atWPthdXeUAwn./OGJZ5hqS9wsi1CAO', N'3', NULL)
GO

INSERT INTO [Users].[users] ([id], [username], [password], [role], [photo_path]) VALUES (N'37', N'xedigadojo232', N'$2y$10$dWqD9uDbU6Auumzb7EqLiOjvbl7FrtqT3pM5vpQ5N5HqBLgSpLuYu', N'2', NULL)
GO

SET IDENTITY_INSERT [Users].[users] OFF
GO


-- ----------------------------
-- View structure for v_dosen
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[v_dosen]') AND type IN ('V'))
	DROP VIEW [Users].[v_dosen]
GO

CREATE VIEW [Users].[v_dosen] AS SELECT
    Users.users.username, 
    Users.users.password, 
    Users.users.role, 
    Users.dosen.id, 
    Users.dosen.nidn, 
    Users.dosen.nama, 
    Users.dosen.jk, 
    Users.dosen.no_hp, 
    Users.dosen.jurusan_id, 
    Akademik.jurusan.nama AS jurusan_nama, 
    Users.dosen.user_id 
FROM
    Users.users
    LEFT JOIN Users.dosen
        ON Users.users.id = Users.dosen.user_id
    LEFT JOIN Akademik.jurusan
        ON Users.dosen.jurusan_id = Akademik.jurusan.id
    
WHERE
    Users.users.role = 3
GO


-- ----------------------------
-- View structure for v_mahasiswa
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[v_mahasiswa]') AND type IN ('V'))
	DROP VIEW [Users].[v_mahasiswa]
GO

CREATE VIEW [Users].[v_mahasiswa] AS SELECT
	Users.mahasiswa.id, 
	Users.mahasiswa.user_id, 
	Users.mahasiswa.nim, 
	Users.mahasiswa.nama, 
	Users.mahasiswa.jk, 
	Users.mahasiswa.kelas_id, 
	Users.mahasiswa.no_hp, 
	Akademik.kelas.prodi_id, 
	Akademik.kelas.nama AS kelas_nama, 
	Akademik.prodi.nama AS prodi_nama, 
	Akademik.prodi.jurusan_id, 
	Akademik.jurusan.nama AS jurusan_nama, 
	Users.mahasiswa.poin, 
	Users.mahasiswa.angkatan, 
	Users.mahasiswa.status, 
	Users.users.username, 
	Users.users.password, 
	Users.users.role
FROM
	Users.users
	LEFT JOIN
	Users.mahasiswa
	ON 
		Users.users.id = Users.mahasiswa.user_id
	LEFT JOIN
	Akademik.kelas
	ON 
		Users.mahasiswa.kelas_id = Akademik.kelas.id
	LEFT JOIN
	Akademik.prodi
	ON 
		Akademik.kelas.prodi_id = Akademik.prodi.id
	LEFT JOIN
	Akademik.jurusan
	ON 
		Akademik.prodi.jurusan_id = Akademik.jurusan.id
    WHERE Users.role = 4
GO


-- ----------------------------
-- View structure for v_staff
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Users].[v_staff]') AND type IN ('V'))
	DROP VIEW [Users].[v_staff]
GO

CREATE VIEW [Users].[v_staff] AS SELECT
	Users.users.username, 
	Users.users.password, 
	Users.users.role, 
	Users.staff.user_id, 
	Users.staff.nip, 
	Users.staff.nama, 
	Users.staff.jk, 
	Users.staff.no_hp, 
	Users.staff.id, 
	Users.staff.prodi_id, 
	Akademik.prodi.nama as prodi_nama, 
	Akademik.prodi.jurusan_id, 
	Akademik.jurusan.nama as jurusan_nama
FROM
	Users.users
	LEFT JOIN
	Users.staff
	ON 
		Users.users.id = Users.staff.user_id
	LEFT JOIN
	Akademik.prodi
	ON 
		Users.staff.prodi_id = Akademik.prodi.id
	LEFT JOIN
	Akademik.jurusan
	ON 
		Akademik.prodi.jurusan_id = Akademik.jurusan.id
    WHERE Users.role = 2
GO


-- ----------------------------
-- Auto increment value for dosen
-- ----------------------------
DBCC CHECKIDENT ('[Users].[dosen]', RESEED, 3)
GO


-- ----------------------------
-- Checks structure for table dosen
-- ----------------------------
ALTER TABLE [Users].[dosen] ADD CONSTRAINT [CK__dosen__jk__36B12243] CHECK ([jk]='P' OR [jk]='L')
GO


-- ----------------------------
-- Primary Key structure for table dosen
-- ----------------------------
ALTER TABLE [Users].[dosen] ADD CONSTRAINT [PK__dosen__3213E83FBE40240F] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for mahasiswa
-- ----------------------------
DBCC CHECKIDENT ('[Users].[mahasiswa]', RESEED, 4)
GO


-- ----------------------------
-- Checks structure for table mahasiswa
-- ----------------------------
ALTER TABLE [Users].[mahasiswa] ADD CONSTRAINT [CK__mahasiswa__jk__31EC6D26] CHECK ([jk]='P' OR [jk]='L')
GO


-- ----------------------------
-- Primary Key structure for table mahasiswa
-- ----------------------------
ALTER TABLE [Users].[mahasiswa] ADD CONSTRAINT [PK__mahasisw__3213E83F1771CE41] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for role
-- ----------------------------
DBCC CHECKIDENT ('[Users].[role]', RESEED, 4)
GO


-- ----------------------------
-- Primary Key structure for table role
-- ----------------------------
ALTER TABLE [Users].[role] ADD CONSTRAINT [PK__role__3213E83FE43097A7] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for staff
-- ----------------------------
DBCC CHECKIDENT ('[Users].[staff]', RESEED, 2)
GO


-- ----------------------------
-- Checks structure for table staff
-- ----------------------------
ALTER TABLE [Users].[staff] ADD CONSTRAINT [CK__staff_keaman__jk__3A81B327] CHECK ([jk]='P' OR [jk]='L')
GO


-- ----------------------------
-- Primary Key structure for table staff
-- ----------------------------
ALTER TABLE [Users].[staff] ADD CONSTRAINT [PK__staff_ke__3213E83F0AD87B3C] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Auto increment value for users
-- ----------------------------
DBCC CHECKIDENT ('[Users].[users]', RESEED, 38)
GO


-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE [Users].[users] ADD CONSTRAINT [PK__users__3213E83F868C30C3] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO


-- ----------------------------
-- Foreign Keys structure for table dosen
-- ----------------------------
ALTER TABLE [Users].[dosen] ADD CONSTRAINT [FK__dosen__user_id__37A5467C] FOREIGN KEY ([user_id]) REFERENCES [Users].[users] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table mahasiswa
-- ----------------------------
ALTER TABLE [Users].[mahasiswa] ADD CONSTRAINT [FK__mahasiswa__user___32E0915F] FOREIGN KEY ([user_id]) REFERENCES [Users].[users] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [Users].[mahasiswa] ADD CONSTRAINT [FK__mahasiswa__kelas__33D4B598] FOREIGN KEY ([kelas_id]) REFERENCES [Akademik].[kelas] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table staff
-- ----------------------------
ALTER TABLE [Users].[staff] ADD CONSTRAINT [FK__staff_kea__user___3B75D760] FOREIGN KEY ([user_id]) REFERENCES [Users].[users] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO


-- ----------------------------
-- Foreign Keys structure for table users
-- ----------------------------
ALTER TABLE [Users].[users] ADD CONSTRAINT [FK__users__role__276EDEB3] FOREIGN KEY ([role]) REFERENCES [Users].[role] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

