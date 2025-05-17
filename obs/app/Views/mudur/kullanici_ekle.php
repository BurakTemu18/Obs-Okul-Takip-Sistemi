<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Ekle</title>
    <link rel="stylesheet" href="/obs/assets/still.css">
</head>
<body class="container mt-5">
    <h2>Kullanıcı Ekle</h2>
    <form action="<?= base_url('mudur/kullanici-kaydet') ?>" method="post">

        <div class="mb-3">
            <label>Rol:</label>
            <select name="role" class="form-control" required>
                <option value="">Seçiniz</option>
                <option value="ogrenci">Öğrenci</option>
                <option value="ogretmen">Öğretmen</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Kullanıcı Adı:</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Şifre:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Ad Soyad:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3" id="ogrenciFields" style="display:none;">
            <label>Öğrenci No:</label>
            <input type="text" name="student_no" class="form-control" value="<?= isset($nextStudentNo) ? $nextStudentNo : '' ?>">
            <label>Sınıf:</label>
            <input type="text" name="class" class="form-control">
        </div>

        <div class="mb-3" id="ogretmenFields" style="display:none;">
            <label>Branş:</label>
            <select name="branch" class="form-control">
                <option value="Türkçe">Türkçe</option>
                <option value="Matematik">Matematik</option>
                <option value="Fizik">Fizik</option>
                <option value="Kimya">Kimya</option>
                <option value="Biyoloji">Biyoloji</option>
            </select>
        </div>

        <button class="btn btn-success">Kaydet</button>
        <a href="<?= base_url('mudur/dashboard') ?>" class="btn btn-secondary">Panele Dön</a>
    </form>

    <script>
        const roleSelect = document.querySelector('select[name="role"]');
        const ogrenciFields = document.getElementById('ogrenciFields');
        const ogretmenFields = document.getElementById('ogretmenFields');

        roleSelect.addEventListener('change', function() {
            ogrenciFields.style.display = this.value === 'ogrenci' ? 'block' : 'none';
            ogretmenFields.style.display = this.value === 'ogretmen' ? 'block' : 'none';
        });
    </script>
</body>
</html>