<?php

namespace Database\Seeders;

use App\Models\AssessmentTemplateAnswer;
use App\Models\AssessmentTemplateQuestion;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentTemplateSeeder extends Seeder
{
    /**
     * Seed pre-test and post-test question templates for every category.
     */
    public function run(): void
    {
        $categories = Category::query()->select('id')->get();

        if ($categories->isEmpty()) {
            $categoryId = DB::table('category')->insertGetId([
                'name' => 'Pelatihan BUM Desa',
            ]);

            $categories = collect([(object) ['id' => $categoryId]]);
        }

        foreach ($categories as $category) {
            foreach (['pre_test', 'post_test'] as $templateType) {
                foreach ($this->questions() as $item) {
                    $question = AssessmentTemplateQuestion::updateOrCreate(
                        [
                            'category_id' => $category->id,
                            'template_type' => $templateType,
                            'question' => $item['question'],
                        ],
                        [
                            'question_type' => null,
                        ]
                    );

                    AssessmentTemplateAnswer::where('assessment_template_question_id', $question->id)->delete();

                    foreach ($item['answers'] as $index => $answer) {
                        AssessmentTemplateAnswer::create([
                            'assessment_template_question_id' => $question->id,
                            'answer' => $answer,
                            'is_correct' => $index === $item['correct_index'],
                        ]);
                    }
                }
            }
        }
    }

    private function questions(): array
    {
        return [
            [
                'question' => 'Yang berhak mengeluarkan sertifikat pendaftaran elektronik BUM Desa menurut PP No. 11 Tahun 2021 adalah:',
                'answers' => [
                    'Kementerian Dalam Negeri',
                    'Kementerian Desa',
                    'Kementerian Hukum dan Hak Asasi Manusia',
                    'Notaris',
                ],
                'correct_index' => 2,
            ],
            [
                'question' => 'Pegawai BUMDesa/BUM Desa Bersama terdiri atas:',
                'answers' => [
                    'Direktur BUMDesa, Sekretaris, Bendahara, Pelaksana Operasional Lainnya',
                    'Direktur BUMDesa, Sekretaris, Bendahara',
                    'Sekretaris, Bendahara, Pegawai Lainnya',
                    'Sekretaris, Bendahara, Pelaksana Operasional, Pegawai Lainnya',
                ],
                'correct_index' => 2,
            ],
            [
                'question' => 'Berikut adalah keadaan yang dapat menyebabkan penghentian kegiatan usaha BUM Desa/BUM Desa Bersama, kecuali:',
                'answers' => [
                    'Direktur BUM Desa mengundurkan diri',
                    'Mengalami kerugian terus menerus yang tidak dapat diselamatkan',
                    'Mencemarkan lingkungan',
                    'Dinyatakan pailit',
                ],
                'correct_index' => 0,
            ],
            [
                'question' => 'Waktu penyampaian laporan pembinaan adalah:',
                'answers' => [
                    'Sewaktu-waktu jika diperlukan',
                    'Secara periodik (berkala)',
                    'Pada akhir pelaksanaan program/kegiatan (satu periode kepengurusan)',
                    'Semua jawaban benar',
                ],
                'correct_index' => 3,
            ],
            [
                'question' => 'Dokumen yang tidak diperlukan dalam pendaftaran BUM Desa berbadan hukum adalah:',
                'answers' => [
                    'Anggaran Dasar & Anggaran Rumah Tangga',
                    'Analisa Kelayakan Usaha BUM Desa',
                    'Program Kerja BUM Desa',
                    'Peraturan Desa tentang Pendirian BUM Desa',
                ],
                'correct_index' => 1,
            ],
            [
                'question' => 'Pendirian BUM Desa/BUM Desa bersama harus didasarkan pada pertimbangan kebutuhan masyarakat, pemecahan masalah bersama, kelayakan usaha, model bisnis dan visi pelestarian, yang mana termuat didalam pasal:',
                'answers' => [
                    'Pasal 117 pada Undang-Undang No. 11 Tahun 2020',
                    'Pasal 117 pada PP No. 11 Tahun 2021',
                    'Pasal 10 pada Permendes No. 3 Tahun 2021',
                    'Pasal 10 pada PP No. 11 Tahun 2021',
                ],
                'correct_index' => 3,
            ],
            [
                'question' => 'Sosialisasi pendirian BUM Desa, pembentukan persiapan tim pendirian BUM Desa, identifikasi potensi, analisis usaha, penyusunan rancangan AD/ART BUM Desa merupakan kegiatan:',
                'answers' => [
                    'Tahapan Pendirian BUM Desa',
                    'Tahapan Pembentukan BUM Desa',
                    'Tahapan Pengelolaan BUM Desa',
                    'Tahapan Manajemen Pengelolaan BUM Desa',
                ],
                'correct_index' => 0,
            ],
            [
                'question' => 'Laporan pertanggungjawaban adalah:',
                'answers' => [
                    'Laporan tentang perbandingan antara hasil yang dicapai dengan dana yang dikeluarkan',
                    'Laporan yang memberikan gambaran tentang pekerjaan yang sedang dilaksanakan (progress report) / sesudah dilaksanakan (bersifat evaluatif)',
                    'Laporan menganalisis suatu situasi/masalah secara mendalam untuk menuju penilaian yang bersifat pilihan',
                    'Laporan yang berisi informasi serta pendapat si pelapor sebagai rekomendasi',
                ],
                'correct_index' => 0,
            ],
            [
                'question' => 'Tujuan dari manajemen SDM pada BUM Desa adalah sebagai berikut, kecuali:',
                'answers' => [
                    'Memperoleh tim kerja pada posisi yang tepat',
                    'Mengurangi pengangguran',
                    'Memberikan kepuasan pada diri tenaga kerja',
                    'Menciptakan iklim dan kondisi kerja yang kondusif',
                ],
                'correct_index' => 1,
            ],
            [
                'question' => 'Yang bukan merupakan strategi pembinaan dan pengembangan BUM Desa adalah:',
                'answers' => [
                    'Revitalisasi kelembagaan BUM Desa',
                    'Peningkatan kualitas manajemen dan penguatan organisasi BUM Desa',
                    'Kemampuan keuangan untuk mengembangkan usaha',
                    'Penguatan kerjasama/kemitraan',
                ],
                'correct_index' => 2,
            ],
            [
                'question' => 'Berikut ini adalah tugas dari Pelaksana Operasional, kecuali:',
                'answers' => [
                    'Menyusun dan melaksanakan rencana program kerja BUM Desa/BUM Desa bersama',
                    'Menyusun laporan semesteran pelaksanaan pengelolaan usaha BUM Desa/BUM Desa bersama untuk diajukan kepada penasihat dan pengawas',
                    'Menyusun laporan tahunan pelaksanaan pengelolaan usaha BUM Desa/BUM Desa bersama untuk diajukan kepada Musyawarah Desa/Musyawarah Antar Desa setelah ditelaah oleh penasihat dan pengawas',
                    'Menyusun audit investigatif terhadap laporan keuangan BUM Desa/BUM Desa bersama',
                ],
                'correct_index' => 3,
            ],
            [
                'question' => 'Pengertian Badan Usaha Milik Desa yang terdapat di Undang-Undang Cipta Kerja No. 11 Tahun 2020 adalah:',
                'answers' => [
                    'BUM Desa adalah badan usaha yang seluruh atau sebagian besar modalnya dimiliki oleh Desa melalui penyertaan secara langsung dari kekayaan Desa yang dipisahkan',
                    'BUM Desa adalah badan hukum yang didirikan oleh desa dan/atau bersama desa-desa untuk mengelola usaha dan meningkatkan kesejahteraan masyarakat',
                    'Perebutan pasar BUM Desa adalah badan usaha yang modalnya dimiliki desa untuk kesejahteraan pemerintah desa',
                    'BUM Desa adalah badan usaha milik pemerintah desa untuk kesejahteraan pemerintah desa',
                ],
                'correct_index' => 1,
            ],
            [
                'question' => 'Yang bukan merupakan manfaat dari pembuatan laporan pembinaan BUMDesa:',
                'answers' => [
                    'Sebagai bukti pelaksanaan kegiatan',
                    'Untuk mengetahui perkembangan suatu kegiatan',
                    'Untuk menunjukkan profesional pengurus',
                    'Sebagai bahan acuan untuk menyusun kegiatan berikutnya',
                ],
                'correct_index' => 2,
            ],
            [
                'question' => 'Peraturan Pemerintah yang merupakan turunan dari Undang-Undang Cipta Kerja No. 11 Tahun 2020 tentang BUM Desa adalah:',
                'answers' => [
                    'PP Nomor 11 Tahun 2021',
                    'PP Nomor 3 Tahun 2021',
                    'PP Nomor 11 Tahun 2020',
                    'PP Nomor 12 Tahun 2021',
                ],
                'correct_index' => 0,
            ],
            [
                'question' => 'Pelaksana Operasional BUM Desa dilantik oleh:',
                'answers' => [
                    'Kepala Desa',
                    'Penasihat',
                    'BPD',
                    'Musyawarah Desa',
                ],
                'correct_index' => 0,
            ],
            [
                'question' => 'Berikut adalah tujuan dari BUM Desa, kecuali:',
                'answers' => [
                    'Mengembangkan ekosistem ekonomi digital di desa',
                    'Pemanfaatan aset desa guna menciptakan nilai tambah',
                    'Memperoleh keuntungan untuk kesejahteraan pengelola BUM Desa',
                    'Melakukan pelayanan umum bagi masyarakat desa',
                ],
                'correct_index' => 2,
            ],
            [
                'question' => 'Lingkup pembinaan pemerintah terhadap BUM Desa memuat unsur:',
                'answers' => [
                    'Pengembangan SDM',
                    'Penguatan kelembagaan',
                    'Peningkatan akses permodalan',
                    'Semua jawaban benar',
                ],
                'correct_index' => 3,
            ],
            [
                'question' => 'Perangkat organisasi BUMDesa/BUMDESMA terdiri dari:',
                'answers' => [
                    'Pembina, Penasihat, Pelaksana Operasional, Pengawas',
                    'Musyawarah Desa/MAD, Penasihat, Pengelola Operasional, Pengawas',
                    'Musyawarah Desa/MAD, Pembina, Penasihat, Pengelola Operasional, Pengawas',
                    'Musyawarah Desa/MAD, Penasihat, Pengelola Operasional, Pengawas, BPD',
                ],
                'correct_index' => 1,
            ],
            [
                'question' => 'Pasal 13 pada Peraturan Pemerintah No. 11 Tahun 2021 membahas tentang:',
                'answers' => [
                    'Struktur Organisasi',
                    'Permodalan',
                    'Anggaran Dasar dan Anggaran Rumah Tangga',
                    'Kerjasama dan Kemitraan',
                ],
                'correct_index' => 2,
            ],
            [
                'question' => 'Yang bukan termasuk ke dalam klasifikasi BUM Desa:',
                'answers' => [
                    'Klasifikasi perintis (skor < 55)',
                    'Klasifikasi pemula (55-70)',
                    'Klasifikasi berkembang (70-85)',
                    'Klasifikasi mandiri (> 85-100)',
                ],
                'correct_index' => 3,
            ],
        ];
    }
}
