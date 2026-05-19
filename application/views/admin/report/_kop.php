<div class="kop">
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <?php if (!empty($logo)): ?>
                    <img src="<?= base_url('uploads/' . $logo) ?>" alt="Logo">
                <?php endif; ?>
            </td>
            <td class="kop-sekolah">
                <h2><?= esc($nama_sekolah) ?></h2>
                <?php if (!empty($alamat)): ?>
                    <p><?= esc($alamat) ?></p>
                <?php endif; ?>
                <?php if (!empty($no_kontak) || !empty($email)): ?>
                    <div class="kop-alamat">
                        <?php if (!empty($no_kontak)): ?>
                            Telp. <?= esc($no_kontak) ?>
                        <?php endif; ?>
                        <?php if (!empty($no_kontak) && !empty($email)): ?>
                            &nbsp;|&nbsp;
                        <?php endif; ?>
                        <?php if (!empty($email)): ?>
                            Email: <?= esc($email) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>

<div class="judul-laporan">
    <?= esc($title) ?>
    <?php if (!empty($subtitle)): ?>
        <div class="subtitle"><?= esc($subtitle) ?></div>
    <?php endif; ?>
</div>
