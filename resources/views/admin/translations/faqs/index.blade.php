<?php
    /** @var \App\Models\FaqCategory[] $categories */
    ?>
@extends('layouts.minimal', [
    'title' => 'KB Translations',
    'footer' => false
])

@section('content')
    <h1>FAQ translation interface</h1>

    {!! Form::open(['route' => 'translations.faq.index', 'method' => 'GET', 'class' => 'form-inline margin-bottom']) !!}

    <div class="form-group">
        <label>Select target language</label>
        <select name="lang" class="form-control">
            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $langData)
                @if ($localeCode === 'en') @continue @endif
                <option value="{{ $localeCode }}" @if(!empty($lang) && $lang == $localeCode) selected="selected" @endif>{{ $localeCode }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary">Confirm</button>
    {!! Form::close() !!}

    @include('partials.success')

    @if (empty($lang))
    <div class="alert alert-info">
        Select a target language first.
    </div>
    @else

    @foreach ($categories as $category)
        {!! Form::open(['route' => 'translations.faq.save', 'method' => 'POST', 'class' => 'form-translations']) !!}
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-sm-6 cursor" data-toggle="collapse" data-target="#category-{{ $category->id }}">
                        <h3 class="box-title">
                            {{ $category->title }} ({{ $category->translatedCount($lang) }} / {{ $category->faqCount() }})
                        </h3>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="title" class="form-control" placeholder="Category name" value="{{ $category->translatedTitle($lang) }}" />
                    </div>
                </div>
            </div>
            <div class="box-body collapse @if ($category->untranslated($lang)) in @endif" id="category-{{ $category->id }}">
                @foreach ($category->sortedFaqs() as $faq)
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>{{ $faq->question }}</h4>
                            {!! $faq->answer !!}
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="faq[{{ $faq->id }}][question]" value="{{ $faq->translatedQuestion($lang) }}" class="form-control" placeholder="{{ $faq->question }}"/><br />

                            <textarea name="faq[{{ $faq->id }}][answer]" class="form-control html-editor" rows="5" style="width: 100%;" placeholder="Answer...">{!! $faq->translatedAnswer($lang) !!}
                            </textarea>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-6">
                        <button class="btn btn-block btn-primary btn-submit">Save changes to {{ $category->title }}</button>
                        <button class="btn btn-block btn-primary btn-ajax" disabled="disabled" style="display: none">
                            <i class="fas fa-spin fa-spinner"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::hidden('category_id', $category->id) !!}
        {!! Form::hidden('locale', $lang) !!}
        {!! Form::close() !!}

    @endforeach
    @endif

    <div
            id="summernote-config"
            data-mention="{{ route('search.live') }}"
            data-advanced-mention="{{ auth()->user()->advancedMentions }}"
            data-months="{{ route('search.calendar-months') }}"
            data-gallery-title="Superboosted Gallery"
            data-gallery-close="{{ __('crud.click_modal.close') }}"
            data-gallery-add="{{ __('crud.add') }}"
            data-gallery-select-all="{{ __('voyager.generic.select_all') }}"
            data-gallery-deselect-all="{{ __('voyager.generic.deselect_all') }}"
            data-gallery-error="generic.gallery.error"
            data-locale="{{ app()->getLocale() }}">
    </div>
@endsection


@include('editors.summernote')

@section('scripts')
    @parent
    <script src="{{ mix('js/admin/admin.js') }}" async></script>
@endsection
