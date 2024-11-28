/*
 Navicat Premium Dump SQL

 Source Server         : sqlsrv-local
 Source Server Type    : SQL Server
 Source Server Version : 15002000 (15.00.2000)
 Source Host           : DESKTOP-I0JL8UH\DBMS1:1433
 Source Catalog        : tatatertib
 Source Schema         : Notification

 Target Server Type    : SQL Server
 Target Server Version : 15002000 (15.00.2000)
 File Encoding         : 65001

 Date: 09/11/2024 13:45:16
*/

IF NOT EXISTS (SELECT * FROM sys.schemas WHERE name = 'Notification')
BEGIN
    EXEC('CREATE SCHEMA Notification');
END
GO


-- ----------------------------
-- Table structure for notification
-- ----------------------------
IF EXISTS (SELECT * FROM sys.all_objects WHERE object_id = OBJECT_ID(N'[Notification].[notification]') AND type IN ('U'))
BEGIN
  DROP TABLE [Notification].[notification]
END
GO

CREATE TABLE [Notification].[notification] (
  [id] int  IDENTITY(1,1) NOT NULL,
  [sender_id] int  NULL,
  [recipient_id] int  NULL,
  [content] text NULL,
  [read_at] datetime  NULL,
  [created_at] datetime  NULL,
  [direct_link] text  NULL
)
GO

ALTER TABLE [Notification].[notification] SET (LOCK_ESCALATION = TABLE)
GO


-- ----------------------------
-- Records of notification
-- ----------------------------
SET IDENTITY_INSERT [Notification].[notification] ON
GO

SET IDENTITY_INSERT [Notification].[notification] OFF
GO


-- ----------------------------
-- Auto increment value for notification
-- ----------------------------


-- ----------------------------
-- Primary Key structure for table notification
-- ----------------------------
ALTER TABLE [Notification].[notification] ADD CONSTRAINT [PK__notifica__3213E83F0875DA15] PRIMARY KEY CLUSTERED ([id])
WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON)  
ON [PRIMARY]
GO

