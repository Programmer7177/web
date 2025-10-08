-- Add jenis column to instansi table
ALTER TABLE instansi ADD COLUMN jenis VARCHAR(50) DEFAULT 'lainnya' AFTER code;

-- Update existing records with jenis based on name patterns
UPDATE instansi SET jenis = 'fakultas' WHERE name LIKE 'Fakultas%';
UPDATE instansi SET jenis = 'perpustakaan' WHERE name LIKE 'Perpustakaan%';
UPDATE instansi SET jenis = 'lainnya' WHERE name LIKE 'Masjid%' OR name LIKE 'Kantin%' OR name LIKE 'Parkir%' OR name LIKE 'Laboratorium%' OR name LIKE 'Gedung%' OR name LIKE 'Aula%';