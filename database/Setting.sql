/*
 Navicat Premium Dump SQL

 Source Server         : sqlsrv-local
 Source Server Type    : SQL Server
 Source Server Version : 15002000 (15.00.2000)
 Source Host           : DESKTOP-I0JL8UH\DBMS1:1433
 Source Catalog        : tatatertib
 Source Schema         : Setting

 Target Server Type    : SQL Server
 Target Server Version : 15002000 (15.00.2000)
 File Encoding         : 65001

 Date: 09/11/2024 13:46:05
*/

IF NOT EXISTS (SELECT * FROM sys.schemas WHERE name = 'Setting')
BEGIN
    EXEC('CREATE SCHEMA Setting');
END
GO

-- ----------------------------
-- Table structure for setting_app
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Setting].[setting_app]') AND type IN ('U'))
BEGIN
  DROP TABLE [Setting].[setting_app]
END
GO

CREATE TABLE [Setting].[setting_app] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [name] varchar(64) NULL,
  [value] varchar(124) NULL
)
GO

ALTER TABLE [Setting].[setting_app] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of setting_app
-- ----------------------------
SET IDENTITY_INSERT [Setting].[setting_app] ON
GO

SET IDENTITY_INSERT [Setting].[setting_app] OFF
GO


-- ----------------------------
-- Auto increment value for setting_app
-- ----------------------------


-- ----------------------------
-- Primary Key structure for table setting_app
-- ----------------------------
ALTER TABLE [Setting].[setting_app] ADD CONSTRAINT [PK__setting___3213E83F315C987E] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO

