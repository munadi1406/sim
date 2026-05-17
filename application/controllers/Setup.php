<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

    public function index() {
        // Cek apakah sudah ada user
        $count = $this->db->count_all('users');
        if ($count > 0) {
            die('<h2>Setup sudah pernah dijalankan. Hapus file ini jika sudah tidak diperlukan.</h2><a href="' . base_url() . '">Kembali ke Beranda</a>');
        }

        $password = password_hash('admin123', PASSWORD_BCRYPT);
        $this->db->insert('users', [
            'username' => 'admin',
            'password' => $password,
            'nama'     => 'Administrator',
            'role'     => 'admin',
        ]);

        echo '<div style="font-family:sans-serif;max-width:500px;margin:80px auto;text-align:center;">';
        echo '<h2 style="color:#4e73df;">✅ Setup Berhasil!</h2>';
        echo '<p>Akun admin telah dibuat:</p>';
        echo '<p><strong>Username:</strong> admin</p>';
        echo '<p><strong>Password:</strong> admin123</p>';
        echo '<a href="' . base_url('login') . '" style="background:#4e73df;color:#fff;padding:10px 24px;border-radius:5px;text-decoration:none;">Login Sekarang</a>';
        echo '</div>';
    }
}
