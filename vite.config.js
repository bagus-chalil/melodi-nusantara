import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/js/master-data/answers.js',
                'resources/js/master-data/categories.js',
                'resources/js/master-data/aspects.js',
                'resources/js/master-data/biodata.js',
                'resources/js/master-data/questions.js',
                'resources/js/guest/survey-form.js',
                'resources/js/admin/survey-detail.js',
                'resources/js/survey.js',
                'resources/js/survey-result.js',
                'resources/js/survey-report-all.js',
                'resources/js/survey-report/survey-report-index',
            ],
            refresh: true,
        }),
    ],
});
