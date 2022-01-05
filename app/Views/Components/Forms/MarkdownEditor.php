<?php

declare(strict_types=1);

namespace App\Views\Components\Forms;

class MarkdownEditor extends FormComponent
{
    public function render(): string
    {
        $editorClass = 'w-full flex flex-col bg-elevated border-3 border-contrast rounded-lg overflow-hidden focus-within:ring-accent ' . $this->class;

        $this->attributes['class'] = 'bg-elevated border-none focus:border-none focus:outline-none focus:ring-0 w-full h-full';
        $this->attributes['rows'] = 6;

        // dd(htmlspecialchars_decode($this->value));
        $value = htmlspecialchars_decode($this->value);

        $textarea = form_textarea($this->attributes, old($this->name, $value, false));
        $icons = [
            'heading' => icon('heading'),
            'bold' => icon('bold'),
            'italic' => icon('italic'),
            'list-unordered' => icon('list-unordered'),
            'list-ordered' => icon('list-ordered'),
            'quote' => icon('quote'),
            'link' => icon('link'),
            'image-add' => icon('image-add'),
            'markdown' => icon(
                'markdown',
                'mr-1 text-lg opacity-40'
            ),
        ];
        $translations = [
            'write' => lang('Common.forms.editor.write'),
            'preview' => lang('Common.forms.editor.preview'),
            'help' => lang('Common.forms.editor.help'),
        ];

        return <<<HTML
            <div class="{$editorClass}">
                <header class="px-2">
                    <div class="sticky top-0 z-20 flex flex-wrap justify-between border-b border-gray-300 bg-elevated">
                        <markdown-write-preview for="{$this->id}" class="relative inline-flex h-8">
                            <button type="button" slot="write" class="px-2 font-semibold focus:ring-inset focus:ring-accent">{$translations['write']}</button>
                            <button type="button" slot="preview" class="px-2 font-semibold focus:ring-inset focus:ring-accent">{$translations['preview']}</button>
                        </markdown-write-preview>
                        <markdown-toolbar for="{$this->id}" class="flex gap-4 px-2 py-1">
                            <div class="inline-flex text-2xl gap-x-1">
                                <md-header class="opacity-50 hover:opacity-100 focus:ring-accent focus:opacity-100">{$icons['heading']}</md-header>
                                <md-bold class="opacity-50 hover:opacity-100 focus:ring-accent focus:opacity-100" data-hotkey-scope="{$this->id}" data-hotkey="Control+b,Meta+b">{$icons['bold']}</md-bold>
                                <md-italic class="opacity-50 hover:opacity-100 focus:ring-accent focus:opacity-100" data-hotkey-scope="{$this->id}" data-hotkey="Control+i,Meta+i">{$icons['italic']}</md-italic>
                            </div>
                            <div class="inline-flex text-2xl gap-x-1">
                                <md-unordered-list class="opacity-50 hover:opacity-100 focus:ring-accent focus:opacity-100">{$icons['list-unordered']}</md-unordered-list>
                                <md-ordered-list class="opacity-50 hover:opacity-100 focus:ring-accent focus:opacity-100">{$icons['list-ordered']}</md-ordered-list>
                            </div>
                            <div class="inline-flex text-2xl gap-x-1">
                                <md-quote class="opacity-50 hover:opacity-100 focus:ring-accent focus:opacity-100">{$icons['quote']}</md-quote>
                                <md-link class="opacity-50 hover:opacity-100 focus:ring-accent focus:opacity-100" data-hotkey-scope="{$this->id}" data-hotkey="Control+k,Meta+k">{$icons['link']}</md-link>
                                <md-image class="opacity-50 hover:opacity-100 focus:ring-accent focus:opacity-100">{$icons['image-add']}</md-image>
                            </div>
                        </markdown-toolbar>
                    </div>
                </header>
                <div class="relative">
                    {$textarea}
                    <markdown-preview for="{$this->id}" class="absolute top-0 left-0 hidden w-full h-full max-w-full px-3 py-2 overflow-y-auto prose bg-base" showClass="bg-elevated" />
                </div>
                <footer class="flex px-2 py-1 border-t bg-base">
                    <a href="https://commonmark.org/help/" class="inline-flex items-center text-xs font-semibold text-skin-muted hover:text-skin-base" target="_blank" rel="noopener noreferrer">{$icons['markdown']}{$translations['help']}</a>
                </footer>
            </div>
        HTML;
    }
}
