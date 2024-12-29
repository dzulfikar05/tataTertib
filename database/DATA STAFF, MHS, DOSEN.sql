-- Data users staff keamanan
SET IDENTITY_INSERT [Users].[users] ON
GO

INSERT INTO [Users].[users] ([id], [username], [password], [role], [photo_path]) 
VALUES 
(N'300', N'10000000001', N'100000000001', N'2', NULL),
(N'301', N'10000000002', N'100000000002', N'2', NULL);

SET IDENTITY_INSERT [Users].[users] OFF
GO

SET IDENTITY_INSERT [Users].[staff] ON
GO

INSERT INTO [Users].[staff] ([id], [user_id], [nip], [nama], [jk], [no_hp], [prodi_id]) VALUES 

(N'300', N'300', N'100000000001', N'Dr. Eng. Rosa Andrie Asmara, S.T., M.T.', N'L', N'08121743514', N'2'),
(N'301', N'301', N'100000000002', N'Mungki Astiningrum, S.T., M.Kom.', N'P', N'08113615482 ', N'2');


SET IDENTITY_INSERT [Users].[staff] OFF
GO

-- Data users Dosen
SET IDENTITY_INSERT [Users].[users] ON
GO

INSERT INTO [Users].[users] ([id], [username], [password], [role], [photo_path]) 
VALUES 
(N'302', N'100000000003', N'100000000003', N'3', NULL),
(N'303', N'100000000004', N'100000000004', N'3', NULL),
(N'304', N'100000000005', N'100000000005', N'3', NULL),
(N'305', N'100000000006', N'100000000006', N'3', NULL),
(N'306', N'100000000007', N'100000000007', N'3', NULL),
(N'307', N'100000000008', N'100000000008', N'3', NULL),
(N'308', N'100000000009', N'100000000009', N'3', NULL),
(N'309', N'100000000010', N'100000000010', N'3', NULL),
(N'310', N'100000000011', N'100000000011', N'3', NULL),
(N'311', N'100000000012', N'100000000012', N'3', NULL),
(N'312', N'100000000013', N'100000000013', N'3', NULL),
(N'313', N'100000000014', N'100000000014', N'3', NULL),
(N'314', N'100000000015', N'100000000015', N'3', NULL),
(N'315', N'100000000016', N'100000000016', N'3', NULL),
(N'316', N'100000000017', N'100000000017', N'3', NULL),
(N'317', N'100000000018', N'100000000018', N'3', NULL),
(N'318', N'100000000019', N'100000000019', N'3', NULL),
(N'319', N'100000000020', N'100000000020', N'3', NULL),
(N'320', N'100000000021', N'100000000021', N'3', NULL),
(N'321', N'100000000022', N'100000000022', N'3', NULL),
(N'322', N'100000000023', N'100000000023', N'3', NULL),
(N'323', N'100000000024', N'100000000024', N'3', NULL),
(N'324', N'100000000025', N'100000000025', N'3', NULL),
(N'325', N'100000000026', N'100000000026', N'3', NULL),
(N'326', N'100000000027', N'100000000027', N'3', NULL),
(N'327', N'100000000028', N'100000000028', N'3', NULL),
(N'328', N'100000000029', N'100000000029', N'3', NULL),
(N'329', N'100000000030', N'100000000030', N'3', NULL),
(N'330', N'100000000031', N'100000000031', N'3', NULL),
(N'331', N'100000000032', N'100000000032', N'3', NULL),
(N'332', N'100000000033', N'100000000033', N'3', NULL),
(N'333', N'100000000034', N'100000000034', N'3', NULL),
(N'334', N'100000000035', N'100000000035', N'3', NULL),
(N'335', N'100000000036', N'100000000036', N'3', NULL),
(N'336', N'100000000037', N'100000000037', N'3', NULL)

SET IDENTITY_INSERT [Users].[users] OFF
GO

SET IDENTITY_INSERT [Users].[dosen] ON
GO

INSERT INTO [Users].[dosen] ([id], [user_id], [nidn], [nama], [jk], [no_hp], [jurusan_id]) 
VALUES 
(N'300', N'302', N'100000000003', N'Agung Nugroho Pramudhita, S.T., M.T.', N'L', N'081334699967', N'1'),
(N'301', N'303', N'100000000004', N'Ahmad Bahauddin Almufaro, S.Pd.I., M.Pd.I.', N'L', N'085101288099', N'1'),
(N'302', N'304', N'100000000005', N'Ahmadi Yuli Ananta, S.T., M.M.', N'L', N'08113037077', N'1'),
(N'303', N'305', N'100000000006', N'Annisa Puspa Kirana, S.Kom, M.Kom.', N'P', N'082142919990', N'1'),
(N'304', N'306', N'100000000007', N'Annisa Taufika Firdausi, S.T., M.T.', N'P', N'0811361847', N'1'),
(N'305', N'307', N'100000000008', N'Anugrah Nur Rahmanto, S.Sn, M.Ds.', N'L', N'0818536604', N'1'),
(N'306', N'308', N'100000000009', N'Aqil Al Ghazali, S.Kom., M.Kom.', N'L', N'081333786546', N'1'),
(N'307', N'309', N'100000000010', N'Ardian Putra, S.T., M.T.', N'L', N'081222334455', N'1'),
(N'308', N'310', N'100000000011', N'Ari Setiawan, S.T., M.T.', N'L', N'081345567890', N'1'),
(N'309', N'311', N'100000000012', N'Bagus Prakoso, S.Kom., M.T.', N'L', N'081908765432', N'1'),
(N'310', N'312', N'100000000013', N'Bima Santoso, S.T., M.T.', N'L', N'081234567890', N'1'),
(N'311', N'313', N'100000000014', N'Citra Melati, S.Kom., M.Kom.', N'P', N'081987654321', N'1'),
(N'312', N'314', N'100000000015', N'Dewi Anggraeni, S.T., M.T.', N'P', N'082123456789', N'1'),
(N'313', N'315', N'100000000016', N'Eka Wijaya, S.Kom., M.Kom.', N'L', N'081823456789', N'1'),
(N'314', N'316', N'100000000017', N'Fadli Ramadhan, S.T., M.T.', N'L', N'081223344556', N'1'),
(N'315', N'317', N'100000000018', N'Gilang Wibowo, S.Kom., M.Kom.', N'L', N'081998877665', N'1'),
(N'316', N'318', N'100000000019', N'Hadi Prayoga, S.T., M.T.', N'L', N'081112223334', N'1'),
(N'317', N'319', N'100000000020', N'Indah Permata Sari, S.Kom., M.Kom.', N'P', N'082334455667', N'1'),
(N'318', N'320', N'100000000021', N'Joko Saputra, S.T., M.T.', N'L', N'081233344455', N'1'),
(N'319', N'321', N'100000000022', N'Kirana Dewi, S.Kom., M.Kom.', N'P', N'081111222333', N'1'),
(N'320', N'322', N'100000000023', N'Laila Rahmawati, S.Kom., M.Kom.', N'P', N'081987123654', N'1'),
(N'321', N'323', N'100000000024', N'Mahendra Putra, S.T., M.T.', N'L', N'081345234567', N'1'),
(N'322', N'324', N'100000000025', N'Nanda Kurniawan, S.Kom., M.Kom.', N'L', N'081223322445', N'1'),
(N'323', N'325', N'100000000026', N'Oka Santoso, S.T., M.T.', N'L', N'081443322111', N'1'),
(N'324', N'326', N'100000000027', N'Putri Ayu, S.Kom., M.Kom.', N'P', N'081987654210', N'1'),
(N'325', N'327', N'100000000028', N'Qiana Rizky, S.T., M.T.', N'P', N'082145678910', N'1'),
(N'326', N'328', N'100000000029', N'Rama Wijaya, S.Kom., M.Kom.', N'L', N'081122334455', N'1'),
(N'327', N'329', N'100000000030', N'Siti Nurhaliza, S.Kom., M.Kom.', N'P', N'082334556778', N'1'),
(N'328', N'330', N'100000000031', N'Taufik Hidayat, S.T., M.T.', N'L', N'081122223344', N'1'),
(N'329', N'331', N'100000000032', N'Umar Zain, S.Kom., M.Kom.', N'L', N'081987654123', N'1'),
(N'330', N'332', N'100000000033', N'Vina Safitri, S.T., M.T.', N'P', N'082113355779', N'1'),
(N'331', N'333', N'100000000034', N'Wulan Puspita, S.Kom., M.Kom.', N'P', N'081999888777', N'1'),
(N'332', N'334', N'100000000035', N'Xaverius Hadi, S.T., M.T.', N'L', N'081122333555', N'1'),
(N'333', N'335', N'100000000036', N'Yasmin Aulia, S.Kom., M.Kom.', N'P', N'082112233445', N'1'),
(N'334', N'336', N'100000000037', N'Zaki Mahendra, S.T., M.T.', N'L', N'081223344667', N'1');

SET IDENTITY_INSERT [Users].[dosen] OFF
GO


-- Data untuk mahasiswa 

SET IDENTITY_INSERT [Users].[users] ON
GO

INSERT INTO [Users].[users] ([id], [username], [password], [role], [photo_path]) 
VALUES 
(N'337', N'12345678', N'12345678', N'4', NULL),
(N'338', N'12345679', N'12345679', N'4', NULL),
(N'339', N'12345680', N'12345680', N'4', NULL),
(N'340', N'12345681', N'12345681', N'4', NULL),
(N'341', N'12345682', N'12345682', N'4', NULL),
(N'342', N'12345683', N'12345683', N'4', NULL),
(N'343', N'12345684', N'12345684', N'4', NULL),
(N'344', N'12345685', N'12345685', N'4', NULL),
(N'345', N'12345686', N'12345686', N'4', NULL),
(N'346', N'12345687', N'12345687', N'4', NULL),
(N'347', N'12345688', N'12345688', N'4', NULL),
(N'348', N'12345689', N'12345689', N'4', NULL),
(N'349', N'12345690', N'12345690', N'4', NULL),
(N'350', N'12345691', N'12345691', N'4', NULL),
(N'351', N'12345692', N'12345692', N'4', NULL),
(N'352', N'12345693', N'12345693', N'4', NULL),
(N'353', N'12345694', N'12345694', N'4', NULL),
(N'354', N'12345695', N'12345695', N'4', NULL),
(N'355', N'12345696', N'12345696', N'4', NULL),
(N'356', N'12345697', N'12345697', N'4', NULL),
(N'357', N'12345698', N'12345698', N'4', NULL),
(N'358', N'12345699', N'12345699', N'4', NULL),
(N'359', N'12345700', N'12345700', N'4', NULL),
(N'360', N'12345701', N'12345701', N'4', NULL),
(N'361', N'12345702', N'12345702', N'4', NULL),
(N'362', N'12345703', N'12345703', N'4', NULL),
(N'363', N'12345704', N'12345704', N'4', NULL),
(N'364', N'12345705', N'12345705', N'4', NULL),
(N'365', N'12345706', N'12345706', N'4', NULL),
(N'366', N'12345707', N'12345707', N'4', NULL),
(N'367', N'12345708', N'12345708', N'4', NULL),
(N'368', N'12345709', N'12345709', N'4', NULL);

SET IDENTITY_INSERT [Users].[users] OFF
GO
SET IDENTITY_INSERT [Users].[mahasiswa] ON
GO

INSERT INTO [Users].[mahasiswa] ([id], [user_id], [nim], [nama], [jk], [kelas_id], [no_hp], [poin], [angkatan], [status]) 
VALUES 
(N'300', N'337', N'12345678', N'Agus Santoso', N'L', N'1', N'087866711494', N'0', N'2023', N'1'),
(N'301', N'338', N'12345679', N'Budi Santoso', N'L', N'1', N'087866711495', N'0', N'2023', N'1'),
(N'302', N'339', N'12345680', N'Citra Dewi', N'P', N'1', N'087866711496', N'0', N'2023', N'1'),
(N'303', N'340', N'12345681', N'Diandra Putri', N'P', N'1', N'087866711497', N'0', N'2023', N'1'),
(N'304', N'341', N'12345682', N'Eka Rizky', N'L', N'1', N'087866711498', N'0', N'2023', N'1'),
(N'305', N'342', N'12345683', N'Fajar Pratama', N'L', N'1', N'087866711499', N'0', N'2023', N'1'),
(N'306', N'343', N'12345684', N'Gina Melinda', N'P', N'1', N'087866711500', N'0', N'2023', N'1'),
(N'307', N'344', N'12345685', N'Haris Wijaya', N'L', N'1', N'087866711501', N'0', N'2023', N'1'),
(N'308', N'345', N'12345686', N'Ika Suryani', N'P', N'1', N'087866711502', N'0', N'2023', N'1'),
(N'309', N'346', N'12345687', N'Jaka Saputra', N'L', N'1', N'087866711503', N'0', N'2023', N'1'),
(N'310', N'347', N'12345688', N'Kartika Ningsih', N'P', N'1', N'087866711504', N'0', N'2023', N'1'),
(N'311', N'348', N'12345689', N'Lia Anggraini', N'P', N'1', N'087866711505', N'0', N'2023', N'1'),
(N'312', N'349', N'12345690', N'Melvin Wijaya', N'L', N'1', N'087866711506', N'0', N'2023', N'1'),
(N'313', N'350', N'12345691', N'Nina Puspitasari', N'P', N'1', N'087866711507', N'0', N'2023', N'1'),
(N'314', N'351', N'12345692', N'Omar Fadli', N'L', N'1', N'087866711508', N'0', N'2023', N'1'),
(N'315', N'352', N'12345693', N'Putri Maharani', N'P', N'1', N'087866711509', N'0', N'2023', N'1'),
(N'316', N'353', N'12345694', N'Rina Sari', N'P', N'1', N'087866711510', N'0', N'2023', N'1'),
(N'317', N'354', N'12345695', N'Sandra Rahma', N'P', N'1', N'087866711511', N'0', N'2023', N'1'),
(N'318', N'355', N'12345696', N'Tony Setiawan', N'L', N'1', N'087866711512', N'0', N'2023', N'1'),
(N'319', N'356', N'12345697', N'Ulfah Nabilah', N'P', N'1', N'087866711513', N'0', N'2023', N'1'),
(N'320', N'357', N'12345698', N'Vina Lestari', N'P', N'1', N'087866711514', N'0', N'2023', N'1'),
(N'321', N'358', N'12345699', N'Wira Dharma', N'L', N'1', N'087866711515', N'0', N'2023', N'1'),
(N'322', N'359', N'12345700', N'Xenia Dewi', N'P', N'1', N'087866711516', N'0', N'2023', N'1'),
(N'323', N'360', N'12345701', N'Yudhi Prasetyo', N'L', N'1', N'087866711517', N'0', N'2023', N'1'),
(N'324', N'361', N'12345702', N'Zara Dwi', N'P', N'1', N'087866711518', N'0', N'2023', N'1'),
(N'325', N'362', N'12345703', N'Ani Suhartini', N'P', N'1', N'087866711519', N'0', N'2023', N'1'),
(N'326', N'363', N'12345704', N'Bambang Taufik', N'L', N'1', N'087866711520', N'0', N'2023', N'1'),
(N'327', N'364', N'12345705', N'Chandra Wijaya', N'L', N'1', N'087866711521', N'0', N'2023', N'1'),
(N'328', N'365', N'12345706', N'Diana Putri', N'P', N'1', N'087866711522', N'0', N'2023', N'1'),
(N'329', N'366', N'12345707', N'Eka Wulan', N'P', N'1', N'087866711523', N'0', N'2023', N'1'),
(N'330', N'367', N'12345708', N'Feri Santoso', N'L', N'1', N'087866711524', N'0', N'2023', N'1'),
(N'331', N'368', N'12345709', N'Gita Wulandari', N'P', N'1', N'087866711525', N'0', N'2023', N'1');

GO

SET IDENTITY_INSERT [Users].[mahasiswa] OFF
GO