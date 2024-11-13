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
-- Ensure the Users schema exists
IF NOT EXISTS (SELECT * FROM sys.schemas WHERE name = 'Users')
BEGIN
    EXEC('CREATE SCHEMA Users');
END
GO

-- Ensure primary key exists for the users table
-- ----------------------------
-- Check if the primary key exists on 'Users.users' and create it if necessary
IF NOT EXISTS (SELECT * FROM sys.key_constraints WHERE parent_object_id = OBJECT_ID('[Users].[users]') AND type = 'PK')
BEGIN
    ALTER TABLE [Users].[users] ADD CONSTRAINT [PK__users__3213E83F] PRIMARY KEY CLUSTERED ([id]);
END
GO

-- Foreign Keys structure for table pelanggaran
-- ----------------------------
-- Foreign Key referencing 'Users.users' table
ALTER TABLE [Pelanggaran].[pelanggaran] ADD CONSTRAINT [FK__pelanggar__pelak__412EB0B6]
    FOREIGN KEY ([pelaku_id]) REFERENCES [Users].[users] ([id]) 
    ON DELETE NO ACTION ON UPDATE NO ACTION;
GO

ALTER TABLE [Pelanggaran].[pelanggaran] ADD CONSTRAINT [FK__pelanggar__pelap__4222D4EF]
    FOREIGN KEY ([pelapor_id]) REFERENCES [Users].[users] ([id]) 
    ON DELETE NO ACTION ON UPDATE NO ACTION;
GO

ALTER TABLE [Pelanggaran].[pelanggaran] ADD CONSTRAINT [FK__pelanggar__verif__4316F928]
    FOREIGN KEY ([verify_by]) REFERENCES [Users].[users] ([id]) 
    ON DELETE NO ACTION ON UPDATE NO ACTION;
GO

-- ----------------------------
-- Foreign Key structure for table sanksi
-- ----------------------------
ALTER TABLE [Pelanggaran].[sanksi] ADD CONSTRAINT [FK__sanksi__pelangga__45F365D3]
    FOREIGN KEY ([pelanggaran_id]) REFERENCES [Pelanggaran].[pelanggaran] ([id]) 
    ON DELETE NO ACTION ON UPDATE NO ACTION;
GO
