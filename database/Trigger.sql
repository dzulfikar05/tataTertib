-- Trigger untuk UPDATE pada tabel 'sanksi' untuk mengupdate kolom 'updated_at'
CREATE TRIGGER trg_update_sanksi_updated_at
ON [Pelanggaran].[sanksi]
AFTER UPDATE
AS
BEGIN
    -- Update kolom 'updated_at' setiap kali ada perubahan pada data
    UPDATE s
    SET s.updated_at = GETDATE()  -- Menggunakan fungsi GETDATE() untuk mencatat waktu update
    FROM [Pelanggaran].[sanksi] s
    INNER JOIN inserted i ON s.id = i.id;  -- Bergabung dengan tabel 'inserted' untuk mendapatkan ID yang diupdate
END
GO