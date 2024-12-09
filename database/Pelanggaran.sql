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

 Date: 22/11/2024 20:22:44
*/

IF NOT EXISTS (SELECT * FROM sys.schemas WHERE name = 'Pelanggaran')
BEGIN
    EXEC('CREATE SCHEMA [Pelanggaran]')
END
GO


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
  [tingkat] int  NULL,
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

INSERT INTO [Pelanggaran].[kategori] ([id], [nama], [keterangan], [tingkat], [bobot]) VALUES (N'3', N'Merokok', N'Merokok di luar area kawasan merokok', N'3', N'3')
GO

INSERT INTO [Pelanggaran].[kategori] ([id], [nama], [keterangan], [bobot]) VALUES (N'4', N'Tindakan Kriminal', N'terlibat dalam tindakan kriminal dan dinyatakan berslaha oleh pengadilan', N'5,' N'1')
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
  [status] char(1) NULL,
  [created_by] int  NULL,
  [bobotUpper] int  NULL,
  [pelapor_role] int  NULL
)
GO

ALTER TABLE [Pelanggaran].[pelanggaran] SET (LOCK_ESCALATION = TABLE)
GO


-- -- ----------------------------
-- -- Records of pelanggaran
-- -- ----------------------------
-- SET IDENTITY_INSERT [Pelanggaran].[pelanggaran] ON
-- GO

-- INSERT INTO [Pelanggaran].[pelanggaran] ([id], [tanggal], [kategori_id], [pelaku_id], [pelapor_id], [keterangan], [verify_by], [verify_at], [status], [created_by], [bobotUpper], [pelapor_role]) VALUES (N'1', N'2024-11-15', N'3', N'2', N'34', N'mencuri pak', N'37', N'2024-11-16 08:37:34.000', N'3', N'1', NULL, N'3')
-- GO

-- INSERT INTO [Pelanggaran].[pelanggaran] ([id], [tanggal], [kategori_id], [pelaku_id], [pelapor_id], [keterangan], [verify_by], [verify_at], [status], [created_by], [bobotUpper], [pelapor_role]) VALUES (N'2', N'2024-11-15', N'3', N'2', N'34', N'nyolongggg nyolong', N'37', N'2024-11-16 08:37:26.000', N'3', NULL, NULL, N'3')
-- GO

-- INSERT INTO [Pelanggaran].[pelanggaran] ([id], [tanggal], [kategori_id], [pelaku_id], [pelapor_id], [keterangan], [verify_by], [verify_at], [status], [created_by], [bobotUpper], [pelapor_role]) VALUES (N'5', N'2024-11-15', N'3', N'2', N'34', N'testes tes', N'37', N'2024-11-16 08:37:17.000', N'2', NULL, NULL, N'3')
-- GO

-- INSERT INTO [Pelanggaran].[pelanggaran] ([id], [tanggal], [kategori_id], [pelaku_id], [pelapor_id], [keterangan], [verify_by], [verify_at], [status], [created_by], [bobotUpper], [pelapor_role]) VALUES (N'6', N'2024-11-15', N'3', N'2', N'34', N'cek', N'37', NULL, N'4', NULL, NULL, N'3')
-- GO

-- INSERT INTO [Pelanggaran].[pelanggaran] ([id], [tanggal], [kategori_id], [pelaku_id], [pelapor_id], [keterangan], [verify_by], [verify_at], [status], [created_by], [bobotUpper], [pelapor_role]) VALUES (N'7', N'2024-11-16', N'4', N'2', N'34', N'gwendeng', N'37', N'2024-11-16 01:37:03.000', N'2', NULL, NULL, N'3')
-- GO

-- INSERT INTO [Pelanggaran].[pelanggaran] ([id], [tanggal], [kategori_id], [pelaku_id], [pelapor_id], [keterangan], [verify_by], [verify_at], [status], [created_by], [bobotUpper], [pelapor_role]) VALUES (N'8', N'2024-11-19', N'3', N'2', N'34', N'hhhhh', N'37', N'2024-11-19 13:45:20.000', N'3', NULL, NULL, N'3')
-- GO

-- INSERT INTO [Pelanggaran].[pelanggaran] ([id], [tanggal], [kategori_id], [pelaku_id], [pelapor_id], [keterangan], [verify_by], [verify_at], [status], [created_by], [bobotUpper], [pelapor_role]) VALUES (N'9', N'2024-11-20', N'3', N'2', N'34', N'cek', N'37', N'2024-11-20 15:03:25.000', N'2', NULL, N'1', N'3')
-- GO

-- INSERT INTO [Pelanggaran].[pelanggaran] ([id], [tanggal], [kategori_id], [pelaku_id], [pelapor_id], [keterangan], [verify_by], [verify_at], [status], [created_by], [bobotUpper], [pelapor_role]) VALUES (N'10', N'2024-11-20', N'3', N'2', N'34', N'MEROKOK', N'37', N'2024-11-20 13:09:54.000', N'3', NULL, NULL, N'3')
-- GO

-- INSERT INTO [Pelanggaran].[pelanggaran] ([id], [tanggal], [kategori_id], [pelaku_id], [pelapor_id], [keterangan], [verify_by], [verify_at], [status], [created_by], [bobotUpper], [pelapor_role]) VALUES (N'11', N'2024-11-20', NULL, N'2', N'37', N'asdsd', NULL, N'2024-11-20 20:40:31.000', N'1', NULL, NULL, N'2')
-- GO

-- SET IDENTITY_INSERT [Pelanggaran].[pelanggaran] OFF
-- GO


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
  [komentar] text NULL,
  [updated_at] datetime  NULL,
  [deadline_date] date  NULL,
  [deadline_time] time(7)  NULL,
  [komentar_revisi] text NULL
)
GO

ALTER TABLE [Pelanggaran].[sanksi] SET (LOCK_ESCALATION = TABLE)
GO


-- -- ----------------------------
-- -- Records of sanksi
-- -- ----------------------------
-- SET IDENTITY_INSERT [Pelanggaran].[sanksi] ON
-- GO

-- INSERT INTO [Pelanggaran].[sanksi] ([id], [pelanggaran_id], [tugas], [keterangan], [verify_by], [status], [komentar], [updated_at], [deadline_date], [deadline_time], [komentar_revisi]) VALUES (N'1', N'1', N'menyapu halaman', N'keteranganw23', NULL, N'4', N'komentar  gess', N'2024-11-18 00:05:59.177', N'2024-11-17', N'18:43:00.0000000', N'')
-- GO

-- INSERT INTO [Pelanggaran].[sanksi] ([id], [pelanggaran_id], [tugas], [keterangan], [verify_by], [status], [komentar], [updated_at], [deadline_date], [deadline_time], [komentar_revisi]) VALUES (N'3', N'2', N'nyaponi lorong', N'lorong 1', NULL, N'4', N'', N'2024-11-19 13:51:28.313', NULL, NULL, N'')
-- GO

-- INSERT INTO [Pelanggaran].[sanksi] ([id], [pelanggaran_id], [tugas], [keterangan], [verify_by], [status], [komentar], [updated_at], [deadline_date], [deadline_time], [komentar_revisi]) VALUES (N'5', N'8', N'ggggg', N'wewe', NULL, N'4', N'sudha', N'2024-11-19 21:22:47.040', N'2024-11-19', N'21:21:00.0000000', N'')
-- GO

-- INSERT INTO [Pelanggaran].[sanksi] ([id], [pelanggaran_id], [tugas], [keterangan], [verify_by], [status], [komentar], [updated_at], [deadline_date], [deadline_time], [komentar_revisi]) VALUES (N'6', N'10', N'Membuat surat penyataan', N'dibubuhi materai, ttd mhs, DPA', NULL, N'4', N'', N'2024-11-20 13:19:04.927', N'2024-11-21', N'13:10:00.0000000', N'')
-- GO

-- INSERT INTO [Pelanggaran].[sanksi] ([id], [pelanggaran_id], [tugas], [keterangan], [verify_by], [status], [komentar], [updated_at], [deadline_date], [deadline_time], [komentar_revisi]) VALUES (N'7', N'9', N'melakukan aksi', N'keterangan', NULL, N'1', NULL, NULL, N'2024-11-20', N'15:10:00.0000000', NULL)
-- GO

-- SET IDENTITY_INSERT [Pelanggaran].[sanksi] OFF
-- GO


-- ----------------------------
-- View structure for v_pelanggaran
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Pelanggaran].[v_pelanggaran]') AND type IN ('V'))
	DROP VIEW [Pelanggaran].[v_pelanggaran]
GO

CREATE VIEW [Pelanggaran].[v_pelanggaran] AS SELECT
    sk.tugas, 
    p.pelapor_role,
    p.tanggal, 
    p.id,
    p.kategori_id, 
    p.id AS pelanggaran_id, 
    p.pelaku_id, 
    p.pelapor_id, 
    p.keterangan, 
    p.verify_by, 
    p.verify_at, 
    p.created_by, 
    p.status, 
    p.bobotUpper, 
    k.nama AS kategori_nama, 
    k.keterangan AS kategori_keterangan, 
    k.bobot AS kategori_bobot, 
    pu.username AS terlapor_user_username, 
    pu.role AS terlapor_user_role, 
    pm.id AS terlapor_mahasiswa_id, 
    pm.nim AS terlapor_mahasiswa_nim, 
    pm.nama AS terlapor_mahasiswa_nama, 
    pm.jk AS terlapor_mahasiswa_jk, 
    pm.kelas_id AS terlapor_mahasiswa_kelas_id, 
    pm.no_hp AS terlapor_mahasiswa_no_hp, 
    pm.poin AS terlapor_mahasiswa_poin, 
    pp.username AS pelapor_user_username, 
    pp.role AS pelapor_user_role, 
    pd.nidn AS pelapor_dosen_nidn, 
    pd.nama AS pelapor_dosen_nama, 
    pd.jk AS pelapor_dosen_jk, 
    pd.no_hp AS pelapor_dosen_no_hp, 
    pv.username AS verifikator_user_username, 
    pv.role AS verifikator_user_role, 
    vs.nip AS verifikator_staff_nip, 
    vs.nama AS verifikator_staff_nama, 
    vs.jk AS verifikator_staff_jk, 
    vs.no_hp AS verifikator_staff_no_hp, 
    sk.status AS sanksi_status, 
    sk.id AS sanksi_id, 
    ps.username AS pelapor_staff_username, 
    ps.role AS pelapor_staff_role, 
    ps_staff.nip AS pelapor_staff_nip, 
    ps_staff.nama AS pelapor_staff_nama, 
    ps_staff.jk AS pelapor_staff_jk, 
    ps_staff.no_hp AS pelapor_staff_no_hp
FROM
    Pelanggaran.pelanggaran AS p
LEFT JOIN
    Pelanggaran.kategori AS k ON p.kategori_id = k.id
LEFT JOIN
    Pelanggaran.sanksi AS sk ON p.id = sk.pelanggaran_id
LEFT JOIN
    Users.users AS pu ON p.pelaku_id = pu.id
LEFT JOIN
    Users.mahasiswa AS pm ON pu.id = pm.user_id
LEFT JOIN
    Users.users AS pp ON p.pelapor_id = pp.id
LEFT JOIN
    Users.dosen AS pd ON pp.id = pd.user_id
LEFT JOIN
    Users.users AS pv ON p.verify_by = pv.id
LEFT JOIN
    Users.staff AS vs ON pv.id = vs.user_id
LEFT JOIN
    Users.users AS ps ON p.pelapor_id = ps.id
LEFT JOIN
    Users.staff AS ps_staff ON ps.id = ps_staff.user_id;
GO


-- ----------------------------
-- View structure for v_sanksi
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Pelanggaran].[v_sanksi]') AND type IN ('V'))
	DROP VIEW [Pelanggaran].[v_sanksi]
GO

CREATE VIEW [Pelanggaran].[v_sanksi] AS SELECT
	sanksi.id, 
	sanksi.tugas, 
	sanksi.keterangan, 
	sanksi.verify_by, 
	sanksi.status, 
	sanksi.komentar, 
	sanksi.komentar_revisi, 
	v_pelanggaran.tanggal AS pelanggaran_tanggal, 
	v_pelanggaran.keterangan AS pelanggaran_keterangan, 
	v_pelanggaran.kategori_nama AS pelanggaran_kategori_nama, 
	v_pelanggaran.terlapor_mahasiswa_nim AS pelanggaran_mahasiswa_nim, 
	v_pelanggaran.terlapor_mahasiswa_nama AS pelanggaran_mahasiswa_nama, 
	v_pelanggaran.pelaku_id AS pelanggaran_pelaku_id, 
	v_pelanggaran.pelapor_id AS pelanggaran_pelapor_id, 
	v_pelanggaran.pelapor_dosen_nidn AS pelanggaran_dosen_nidn, 
	v_pelanggaran.pelapor_dosen_nama AS pelanggaran_dosen_nama, 
	sanksi.pelanggaran_id, 
	v_pelanggaran.status AS pelanggaran_status, 
	v_pelanggaran.kategori_bobot, 
	v_pelanggaran.bobotUpper, 
	FORMAT(sanksi.deadline_date, 'yyyy-MM-dd') AS deadline_date, 
	CONVERT(VARCHAR(5), sanksi.deadline_time, 108) AS deadline_time, 
	 
	v_pelanggaran.verify_by AS pelanggaran_verify_by, 
	sanksi.updated_at
FROM
	Pelanggaran.sanksi
	LEFT JOIN
	Pelanggaran.v_pelanggaran
	ON 
		sanksi.pelanggaran_id = v_pelanggaran.id
GO


-- ----------------------------
-- Auto increment value for kategori
-- ----------------------------
DBCC CHECKIDENT ('[Pelanggaran].[kategori]', RESEED, 6)
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
DBCC CHECKIDENT ('[Pelanggaran].[pelanggaran]', RESEED, 11)
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
DBCC CHECKIDENT ('[Pelanggaran].[sanksi]', RESEED, 7)
GO


-- ----------------------------
-- Triggers structure for table sanksi
-- ----------------------------
CREATE TRIGGER [Pelanggaran].[trg_update_sanksi_updated_at]
ON [Pelanggaran].[sanksi]
WITH EXECUTE AS CALLER
FOR UPDATE
AS
BEGIN
    -- Update kolom 'updated_at' setiap kali ada perubahan pada data
    UPDATE s
    SET s.updated_at = GETDATE()  -- Menggunakan fungsi GETDATE() untuk mencatat waktu update
    FROM [Pelanggaran].[sanksi] s
    INNER JOIN inserted i ON s.id = i.id;  -- Bergabung dengan tabel 'inserted' untuk mendapatkan ID yang diupdate
END
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

ALTER TABLE [Pelanggaran].[pelanggaran] NOCHECK CONSTRAINT [FK__pelanggar__statu__403A8C7D]
GO

ALTER TABLE [Pelanggaran].[pelanggaran] NOCHECK CONSTRAINT [FK__pelanggar__pelak__412EB0B6]
GO

ALTER TABLE [Pelanggaran].[pelanggaran] NOCHECK CONSTRAINT [FK__pelanggar__pelap__4222D4EF]
GO

ALTER TABLE [Pelanggaran].[pelanggaran] NOCHECK CONSTRAINT [FK__pelanggar__verif__4316F928]
GO


-- ----------------------------
-- Foreign Keys structure for table sanksi
-- ----------------------------
ALTER TABLE [Pelanggaran].[sanksi] ADD CONSTRAINT [FK__sanksi__pelangga__45F365D3] FOREIGN KEY ([pelanggaran_id]) REFERENCES [Pelanggaran].[pelanggaran] ([id]) ON DELETE NO ACTION ON UPDATE NO ACTION
GO

ALTER TABLE [Pelanggaran].[sanksi] NOCHECK CONSTRAINT [FK__sanksi__pelangga__45F365D3]
GO

