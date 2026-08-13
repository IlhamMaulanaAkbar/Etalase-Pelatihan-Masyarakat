<?php

namespace Database\Seeders;

use App\Models\AssessmentTemplateAnswer;
use App\Models\AssessmentTemplateQuestion;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvaluationTemplateSeeder extends Seeder
{
    /**
     * Seed training and instructor evaluation templates for every category.
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
            foreach ($this->templates() as $templateType => $questions) {
                foreach ($questions as $item) {
                    $question = AssessmentTemplateQuestion::updateOrCreate(
                        [
                            'category_id' => $category->id,
                            'template_type' => $templateType,
                            'question' => $item['question'],
                        ],
                        [
                            'question_type' => $item['question_type'],
                        ]
                    );

                    AssessmentTemplateAnswer::where('assessment_template_question_id', $question->id)->delete();

                    if ($item['question_type'] === 'scale') {
                        foreach ($this->scaleAnswers() as $answer) {
                            AssessmentTemplateAnswer::create([
                                'assessment_template_question_id' => $question->id,
                                'answer' => $answer,
                                'is_correct' => false,
                            ]);
                        }
                    }
                }
            }
        }
    }

    private function templates(): array
    {
        return [
            'training_evaluation' => $this->trainingEvaluationQuestions(),
            'instructor_evaluation' => $this->instructorEvaluationQuestions(),
        ];
    }

    private function trainingEvaluationQuestions(): array
    {
        return [
            [
                'question' => 'Materi pelatihan sesuai dengan kebutuhan peserta.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Tujuan pelatihan disampaikan dengan jelas.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Materi pelatihan mudah dipahami dan diterapkan.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Metode pembelajaran mendukung pemahaman peserta.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Waktu pelaksanaan pelatihan sudah sesuai dengan kebutuhan materi.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Fasilitas pelatihan mendukung proses pembelajaran.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Bahan ajar atau media pelatihan membantu peserta memahami materi.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Pelatihan meningkatkan pengetahuan dan keterampilan peserta.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Pelayanan panitia selama pelatihan berjalan dengan baik.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Pelatihan ini layak direkomendasikan kepada peserta lain.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Apa manfaat utama yang Anda peroleh dari pelatihan ini?',
                'question_type' => 'text',
            ],
            [
                'question' => 'Berikan saran untuk peningkatan pelatihan berikutnya.',
                'question_type' => 'text',
            ],
        ];
    }

    private function instructorEvaluationQuestions(): array
    {
        return [
            [
                'question' => 'Instruktur menguasai materi pelatihan dengan baik.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Instruktur menyampaikan materi secara jelas dan sistematis.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Instruktur mampu menjawab pertanyaan peserta dengan baik.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Instruktur menggunakan metode pembelajaran yang menarik.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Instruktur memberikan contoh atau studi kasus yang relevan.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Instruktur mendorong peserta untuk aktif berdiskusi.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Instruktur mengelola waktu pembelajaran dengan baik.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Instruktur bersikap komunikatif dan mudah dipahami.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Instruktur memberikan umpan balik yang membantu peserta.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Secara keseluruhan, kinerja instruktur dalam pelatihan ini sangat baik.',
                'question_type' => 'scale',
            ],
            [
                'question' => 'Apa hal terbaik dari penyampaian instruktur?',
                'question_type' => 'text',
            ],
            [
                'question' => 'Berikan saran untuk peningkatan kualitas instruktur.',
                'question_type' => 'text',
            ],
        ];
    }

    private function scaleAnswers(): array
    {
        return [
            'Sangat Buruk',
            'Buruk',
            'Cukup',
            'Baik',
            'Sangat Baik',
        ];
    }
}
