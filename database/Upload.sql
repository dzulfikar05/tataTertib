/*
 Navicat Premium Dump SQL

 Source Server         : sqlsrv-local
 Source Server Type    : SQL Server
 Source Server Version : 15002000 (15.00.2000)
 Source Host           : DESKTOP-I0JL8UH\DBMS1:1433
 Source Catalog        : tatatertib
 Source Schema         : Upload

 Target Server Type    : SQL Server
 Target Server Version : 15002000 (15.00.2000)
 File Encoding         : 65001

 Date: 09/11/2024 13:45:55
*/


-- ----------------------------
-- Table structure for file_upload
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Upload].[file_upload]') AND type IN ('U'))
	DROP TABLE [Upload].[file_upload]
GO

CREATE TABLE [Upload].[file_upload] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [model_name] varchar(64)  NULL,
  [model_id] int  NULL,
  [file_type] varchar(12)  NULL,
  [path] text  NULL,
  [file_name] varchar(255)  NULL
)
GO

ALTER TABLE [Upload].[file_upload] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of file_upload
-- ----------------------------
SET IDENTITY_INSERT [Upload].[file_upload] ON
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'2', N'Users.users', N'11', N'png', N'uploads/users/mahasiswa/1731071909.png', N'pngegg.png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'18', N'Users.users', N'27', N'png', N'uploads/users/mahasiswa/1731074031.png', N'pngegg.png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'19', N'Users.users', N'28', N'png', N'uploads/users/mahasiswa/1731074126.png', N'pngegg.png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'21', N'Users.users', NULL, N'png', N'uploads/users/mahasiswa/1731079884.png', N'logout.png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'22', N'Users.users', NULL, N'png', N'uploads/users/mahasiswa/1731079964.png', N'logout.png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'23', N'Users.users', NULL, N'png', N'uploads/users/mahasiswa/1731080160.png', N'logout.png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'24', N'Users.users', NULL, N'png', N'uploads/users/mahasiswa/1731080199.png', N'logout.png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'25', N'Users.users', NULL, N'png', N'uploads/users/mahasiswa/1731080221.png', N'logout.png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'26', N'Users.users', NULL, N'png', N'uploads/users/mahasiswa/1731080240.png', N'logout.png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'27', N'Users.users', N'3', N'png', N'uploads/users/mahasiswa/1731080293.png', N'logout.png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'29', N'Users.users', N'29', N'png', N'uploads/users/mahasiswa/1731080460.png', N'Analisa Proses Bisnis PBL.drawio (1).png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'31', N'Users.users', N'34', N'jpg', N'uploads/users/dosen/1731084431.jpg', N'USE CASE_TATIB_RPL.jpg')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'33', N'Users.users', N'36', N'png', N'uploads/users/staff/1731086471.png', N'logout.png')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'36', N'Users.users', N'37', N'jpg', N'uploads/users/staff/1731134235.jpg', N'user.jpg')
GO

INSERT INTO [Upload].[file_upload] ([id], [model_name], [model_id], [file_type], [path], [file_name]) VALUES (N'37', N'Users.users', N'2', N'jpg', N'uploads/users/mahasiswa/1731134575.jpg', N'BRZIKO_01.jpg')
GO

SET IDENTITY_INSERT [Upload].[file_upload] OFF
GO


-- ----------------------------
-- Auto increment value for file_upload
-- ----------------------------
DBCC CHECKIDENT ('[Upload].[file_upload]', RESEED, 37)
GO


-- ----------------------------
-- Primary Key structure for table file_upload
-- ----------------------------
ALTER TABLE [Upload].[file_upload] ADD CONSTRAINT [PK__file_upl__3213E83F19161840] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO

