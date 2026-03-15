<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\View\View;

class LegalPageController extends Controller
{
    /**
     * Show privacy policy page.
     */
    public function privacy(): View
    {
        $pageData = $this->makePageData('privacy');

        return view('legal.privacy', $pageData);
    }

    /**
     * Show terms of service page.
     */
    public function terms(): View
    {
        $pageData = $this->makePageData('terms');

        return view('legal.terms', $pageData);
    }

    /**
     * Show cookie policy page.
     */
    public function cookies(): View
    {
        $pageData = $this->makePageData('cookies');

        return view('legal.cookies', $pageData);
    }

    /**
     * @return array{lastUpdated: string, introText: string, summaryItems: array<int, string>, sections: array<int, array{heading: string, paragraphs: array<int, string>}>}
     */
    private function makePageData(string $page): array
    {
        $settings = SiteSetting::getLegalSettings();
        $summaryRaw = (string) ($settings["legal_{$page}_summary"] ?? '');
        $contentRaw = (string) ($settings["legal_{$page}_content"] ?? '');

        return [
            'lastUpdated' => (string) ($settings['legal_last_updated'] ?? 'March 15, 2026'),
            'introText' => (string) ($settings["legal_{$page}_intro"] ?? ''),
            'summaryItems' => $this->parseSummary($summaryRaw),
            'sections' => $this->parseSections($contentRaw),
        ];
    }

    /**
     * @return array<int, string>
     */
    private function parseSummary(string $raw): array
    {
        $lines = preg_split('/\R+/', trim($raw)) ?: [];

        return array_values(array_filter(array_map(static function (string $line): string {
            $trimmed = trim($line);

            if (str_starts_with($trimmed, '- ')) {
                return trim(substr($trimmed, 2));
            }

            return $trimmed;
        }, $lines), static fn (string $line): bool => $line !== ''));
    }

    /**
     * @return array<int, array{heading: string, paragraphs: array<int, string>}>
     */
    private function parseSections(string $raw): array
    {
        $blocks = preg_split('/\R{2,}/', trim($raw)) ?: [];
        $sections = [];
        $currentHeading = '';
        $currentParagraphs = [];

        foreach ($blocks as $block) {
            $trimmedBlock = trim($block);

            if ($trimmedBlock === '') {
                continue;
            }

            if (str_starts_with($trimmedBlock, '## ')) {
                if ($currentHeading !== '' || $currentParagraphs !== []) {
                    $sections[] = [
                        'heading' => $currentHeading,
                        'paragraphs' => $currentParagraphs,
                    ];
                }

                $lines = preg_split('/\R/', $trimmedBlock) ?: [];
                $headingLine = array_shift($lines) ?: '';

                $currentHeading = trim(substr($headingLine, 3));
                $currentParagraphs = [];

                $firstParagraph = trim(implode(' ', array_map('trim', array_filter($lines, static fn (string $line): bool => trim($line) !== ''))));

                if ($firstParagraph !== '') {
                    $currentParagraphs[] = $firstParagraph;
                }

                continue;
            }

            $currentParagraphs[] = trim(preg_replace('/\s+/', ' ', $trimmedBlock) ?? $trimmedBlock);
        }

        if ($currentHeading !== '' || $currentParagraphs !== []) {
            $sections[] = [
                'heading' => $currentHeading !== '' ? $currentHeading : 'Details',
                'paragraphs' => $currentParagraphs,
            ];
        }

        return $sections;
    }
}
