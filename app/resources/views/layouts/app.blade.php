<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Sistema de Facturación | AllpaSoft</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        .sidebar {
            transition: all 0.3s ease;
        }

        .sidebar-link {
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .sidebar-link:hover {
            background-color: rgba(79, 70, 229, 0.1);
        }

        .sidebar-link.active {
            background-color: rgba(79, 70, 229, 0.1);
            border-left: 3px solid #4f46e5;
        }

        .sidebar-text {
            transition: opacity 0.2s ease;
        }

        .sidebar-mini {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            z-index: 10;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            border-radius: 9999px;
            padding: 0.15rem 0.35rem;
            font-size: 0.65rem;
            font-weight: 600;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-badge.paid {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-badge.pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-badge.overdue {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .chart-container {
            position: relative;
            height: 220px;
            width: 100%;
        }

        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        /* Estados activos para navegación */
        .nav-link.active {
            background-color: rgb(238 242 255);
            color: rgb(67 56 202);
        }

        .nav-link.active i {
            color: rgb(99 102 241) !important;
        }
    </style>
    <style>
        *,
        ::before,
        ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style:
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style:
        }

        /* ! tailwindcss v3.4.16 | MIT License | https://tailwindcss.com */
        *,
        ::after,
        ::before {
            box-sizing: border-box;
            border-width: 0;
            border-style: solid;
            border-color: #e5e7eb
        }

        ::after,
        ::before {
            --tw-content: ''
        }

        :host,
        html {
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
            -moz-tab-size: 4;
            tab-size: 4;
            font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-feature-settings: normal;
            font-variation-settings: normal;
            -webkit-tap-highlight-color: transparent
        }

        body {
            margin: 0;
            line-height: inherit
        }

        hr {
            height: 0;
            color: inherit;
            border-top-width: 1px
        }

        abbr:where([title]) {
            -webkit-text-decoration: underline dotted;
            text-decoration: underline dotted
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        b,
        strong {
            font-weight: bolder
        }

        code,
        kbd,
        pre,
        samp {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-feature-settings: normal;
            font-variation-settings: normal;
            font-size: 1em
        }

        small {
            font-size: 80%
        }

        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline
        }

        sub {
            bottom: -.25em
        }

        sup {
            top: -.5em
        }

        table {
            text-indent: 0;
            border-color: inherit;
            border-collapse: collapse
        }

        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            font-feature-settings: inherit;
            font-variation-settings: inherit;
            font-size: 100%;
            font-weight: inherit;
            line-height: inherit;
            letter-spacing: inherit;
            color: inherit;
            margin: 0;
            padding: 0
        }

        button,
        select {
            text-transform: none
        }

        button,
        input:where([type=button]),
        input:where([type=reset]),
        input:where([type=submit]) {
            -webkit-appearance: button;
            background-color: transparent;
            background-image: none
        }

        :-moz-focusring {
            outline: auto
        }

        :-moz-ui-invalid {
            box-shadow: none
        }

        progress {
            vertical-align: baseline
        }

        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto
        }

        [type=search] {
            -webkit-appearance: textfield;
            outline-offset: -2px
        }

        ::-webkit-search-decoration {
            -webkit-appearance: none
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        summary {
            display: list-item
        }

        blockquote,
        dd,
        dl,
        figure,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        p,
        pre {
            margin: 0
        }

        fieldset {
            margin: 0;
            padding: 0
        }

        legend {
            padding: 0
        }

        menu,
        ol,
        ul {
            list-style: none;
            margin: 0;
            padding: 0
        }

        dialog {
            padding: 0
        }

        textarea {
            resize: vertical
        }

        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            color: #9ca3af
        }

        [role=button],
        button {
            cursor: pointer
        }

        :disabled {
            cursor: default
        }

        audio,
        canvas,
        embed,
        iframe,
        img,
        object,
        svg,
        video {
            display: block;
            vertical-align: middle
        }

        img,
        video {
            max-width: 100%;
            height: auto
        }

        [hidden]:where(:not([hidden=until-found])) {
            display: none
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0
        }

        .fixed {
            position: fixed
        }

        .absolute {
            position: absolute
        }

        .relative {
            position: relative
        }

        .sticky {
            position: sticky
        }

        .inset-0 {
            inset: 0px
        }

        .bottom-0 {
            bottom: 0px
        }

        .bottom-4 {
            bottom: 1rem
        }

        .left-0 {
            left: 0px
        }

        .left-3 {
            left: 0.75rem
        }

        .right-4 {
            right: 1rem
        }

        .top-0 {
            top: 0px
        }

        .top-2\.5 {
            top: 0.625rem
        }

        .z-0 {
            z-index: 0
        }

        .z-10 {
            z-index: 10
        }

        .z-40 {
            z-index: 40
        }

        .z-50 {
            z-index: 50
        }

        .mb-1 {
            margin-bottom: 0.25rem
        }

        .mb-4 {
            margin-bottom: 1rem
        }

        .mb-6 {
            margin-bottom: 1.5rem
        }

        .ml-2 {
            margin-left: 0.5rem
        }

        .ml-3 {
            margin-left: 0.75rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .ml-auto {
            margin-left: auto
        }

        .mr-1 {
            margin-right: 0.25rem
        }

        .mr-2 {
            margin-right: 0.5rem
        }

        .mr-3 {
            margin-right: 0.75rem
        }

        .mr-4 {
            margin-right: 1rem
        }

        .mt-1 {
            margin-top: 0.25rem
        }

        .mt-2 {
            margin-top: 0.5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .block {
            display: block
        }

        .flex {
            display: flex
        }

        .inline-flex {
            display: inline-flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .h-10 {
            height: 2.5rem
        }

        .h-12 {
            height: 3rem
        }

        .h-4 {
            height: 1rem
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-full {
            height: 100%
        }

        .h-screen {
            height: 100vh
        }

        .max-h-64 {
            max-height: 16rem
        }

        .max-h-\[90vh\] {
            max-height: 90vh
        }

        .w-10 {
            width: 2.5rem
        }

        .w-12 {
            width: 3rem
        }

        .w-20 {
            width: 5rem
        }

        .w-24 {
            width: 6rem
        }

        .w-4 {
            width: 1rem
        }

        .w-40 {
            width: 10rem
        }

        .w-48 {
            width: 12rem
        }

        .w-5 {
            width: 1.25rem
        }

        .w-56 {
            width: 14rem
        }

        .w-64 {
            width: 16rem
        }

        .w-72 {
            width: 18rem
        }

        .w-8 {
            width: 2rem
        }

        .w-full {
            width: 100%
        }

        .min-w-full {
            min-width: 100%
        }

        .max-w-4xl {
            max-width: 56rem
        }

        .flex-1 {
            flex: 1 1 0%
        }

        .flex-shrink-0 {
            flex-shrink: 0
        }

        .-translate-x-full {
            --tw-translate-x: -100%;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
        }

        .transform {
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        .flex-col {
            flex-direction: column
        }

        .items-start {
            align-items: flex-start
        }

        .items-center {
            align-items: center
        }

        .justify-end {
            justify-content: flex-end
        }

        .justify-center {
            justify-content: center
        }

        .justify-between {
            justify-content: space-between
        }

        .gap-4 {
            gap: 1rem
        }

        .gap-6 {
            gap: 1.5rem
        }

        .-space-x-px> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 0;
            margin-right: calc(-1px * var(--tw-space-x-reverse));
            margin-left: calc(-1px * calc(1 - var(--tw-space-x-reverse)))
        }

        .space-x-2> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 0;
            margin-right: calc(0.5rem * var(--tw-space-x-reverse));
            margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)))
        }

        .space-x-3> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 0;
            margin-right: calc(0.75rem * var(--tw-space-x-reverse));
            margin-left: calc(0.75rem * calc(1 - var(--tw-space-x-reverse)))
        }

        .space-x-4> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 0;
            margin-right: calc(1rem * var(--tw-space-x-reverse));
            margin-left: calc(1rem * calc(1 - var(--tw-space-x-reverse)))
        }

        .space-y-1> :not([hidden])~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(0.25rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(0.25rem * var(--tw-space-y-reverse))
        }

        .space-y-2> :not([hidden])~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(0.5rem * var(--tw-space-y-reverse))
        }

        .space-y-3> :not([hidden])~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(0.75rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(0.75rem * var(--tw-space-y-reverse))
        }

        .space-y-4> :not([hidden])~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(1rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(1rem * var(--tw-space-y-reverse))
        }

        .divide-y> :not([hidden])~ :not([hidden]) {
            --tw-divide-y-reverse: 0;
            border-top-width: calc(1px * calc(1 - var(--tw-divide-y-reverse)));
            border-bottom-width: calc(1px * var(--tw-divide-y-reverse))
        }

        .divide-gray-200> :not([hidden])~ :not([hidden]) {
            --tw-divide-opacity: 1;
            border-color: rgb(229 231 235 / var(--tw-divide-opacity, 1))
        }

        .overflow-hidden {
            overflow: hidden
        }

        .overflow-x-auto {
            overflow-x: auto
        }

        .overflow-y-auto {
            overflow-y: auto
        }

        .whitespace-nowrap {
            white-space: nowrap
        }

        .rounded {
            border-radius: 0.25rem
        }

        .rounded-full {
            border-radius: 9999px
        }

        .rounded-lg {
            border-radius: 0.5rem
        }

        .rounded-md {
            border-radius: 0.375rem
        }

        .rounded-l-md {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem
        }

        .rounded-r-md {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem
        }

        .border {
            border-width: 1px
        }

        .border-b {
            border-bottom-width: 1px
        }

        .border-r {
            border-right-width: 1px
        }

        .border-t {
            border-top-width: 1px
        }

        .border-gray-100 {
            --tw-border-opacity: 1;
            border-color: rgb(243 244 246 / var(--tw-border-opacity, 1))
        }

        .border-gray-200 {
            --tw-border-opacity: 1;
            border-color: rgb(229 231 235 / var(--tw-border-opacity, 1))
        }

        .border-gray-300 {
            --tw-border-opacity: 1;
            border-color: rgb(209 213 219 / var(--tw-border-opacity, 1))
        }

        .border-indigo-500 {
            --tw-border-opacity: 1;
            border-color: rgb(99 102 241 / var(--tw-border-opacity, 1))
        }

        .bg-blue-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(219 234 254 / var(--tw-bg-opacity, 1))
        }

        .bg-gray-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(249 250 251 / var(--tw-bg-opacity, 1))
        }

        .bg-gray-800 {
            --tw-bg-opacity: 1;
            background-color: rgb(31 41 55 / var(--tw-bg-opacity, 1))
        }

        .bg-green-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(220 252 231 / var(--tw-bg-opacity, 1))
        }

        .bg-indigo-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(224 231 255 / var(--tw-bg-opacity, 1))
        }

        .bg-indigo-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(238 242 255 / var(--tw-bg-opacity, 1))
        }

        .bg-indigo-600 {
            --tw-bg-opacity: 1;
            background-color: rgb(79 70 229 / var(--tw-bg-opacity, 1))
        }

        .bg-purple-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(243 232 255 / var(--tw-bg-opacity, 1))
        }

        .bg-red-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(254 226 226 / var(--tw-bg-opacity, 1))
        }

        .bg-red-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(239 68 68 / var(--tw-bg-opacity, 1))
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1))
        }

        .bg-yellow-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(254 249 195 / var(--tw-bg-opacity, 1))
        }

        .bg-opacity-50 {
            --tw-bg-opacity: 0.5
        }

        .p-1 {
            padding: 0.25rem
        }

        .p-2 {
            padding: 0.5rem
        }

        .p-3 {
            padding: 0.75rem
        }

        .p-4 {
            padding: 1rem
        }

        .p-6 {
            padding: 1.5rem
        }

        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .pl-10 {
            padding-left: 2.5rem
        }

        .pr-4 {
            padding-right: 1rem
        }

        .pt-3 {
            padding-top: 0.75rem
        }

        .pt-4 {
            padding-top: 1rem
        }

        .text-left {
            text-align: left
        }

        .text-center {
            text-align: center
        }

        .text-right {
            text-align: right
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem
        }

        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem
        }

        .font-bold {
            font-weight: 700
        }

        .font-medium {
            font-weight: 500
        }

        .font-semibold {
            font-weight: 600
        }

        .uppercase {
            text-transform: uppercase
        }

        .tracking-wider {
            letter-spacing: 0.05em
        }

        .text-blue-600 {
            --tw-text-opacity: 1;
            color: rgb(37 99 235 / var(--tw-text-opacity, 1))
        }

        .text-gray-400 {
            --tw-text-opacity: 1;
            color: rgb(156 163 175 / var(--tw-text-opacity, 1))
        }

        .text-gray-500 {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity, 1))
        }

        .text-gray-600 {
            --tw-text-opacity: 1;
            color: rgb(75 85 99 / var(--tw-text-opacity, 1))
        }

        .text-gray-700 {
            --tw-text-opacity: 1;
            color: rgb(55 65 81 / var(--tw-text-opacity, 1))
        }

        .text-gray-900 {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity, 1))
        }

        .text-green-600 {
            --tw-text-opacity: 1;
            color: rgb(22 163 74 / var(--tw-text-opacity, 1))
        }

        .text-indigo-600 {
            --tw-text-opacity: 1;
            color: rgb(79 70 229 / var(--tw-text-opacity, 1))
        }

        .text-purple-600 {
            --tw-text-opacity: 1;
            color: rgb(147 51 234 / var(--tw-text-opacity, 1))
        }

        .text-red-500 {
            --tw-text-opacity: 1;
            color: rgb(239 68 68 / var(--tw-text-opacity, 1))
        }

        .text-red-600 {
            --tw-text-opacity: 1;
            color: rgb(220 38 38 / var(--tw-text-opacity, 1))
        }

        .text-white {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity, 1))
        }

        .text-yellow-600 {
            --tw-text-opacity: 1;
            color: rgb(202 138 4 / var(--tw-text-opacity, 1))
        }

        .shadow-lg {
            --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .shadow-sm {
            --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .shadow-xl {
            --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .transition-transform {
            transition-property: transform;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .duration-300 {
            transition-duration: 300ms
        }

        .ease-in-out {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1)
        }

        .hover\:bg-gray-100:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(243 244 246 / var(--tw-bg-opacity, 1))
        }

        .hover\:bg-gray-50:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(249 250 251 / var(--tw-bg-opacity, 1))
        }

        .hover\:bg-indigo-700:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(67 56 202 / var(--tw-bg-opacity, 1))
        }

        .hover\:text-gray-600:hover {
            --tw-text-opacity: 1;
            color: rgb(75 85 99 / var(--tw-text-opacity, 1))
        }

        .hover\:text-gray-700:hover {
            --tw-text-opacity: 1;
            color: rgb(55 65 81 / var(--tw-text-opacity, 1))
        }

        .hover\:text-gray-900:hover {
            --tw-text-opacity: 1;
            color: rgb(17 24 39 / var(--tw-text-opacity, 1))
        }

        .hover\:text-indigo-800:hover {
            --tw-text-opacity: 1;
            color: rgb(55 48 163 / var(--tw-text-opacity, 1))
        }

        .hover\:text-indigo-900:hover {
            --tw-text-opacity: 1;
            color: rgb(49 46 129 / var(--tw-text-opacity, 1))
        }

        .hover\:text-red-700:hover {
            --tw-text-opacity: 1;
            color: rgb(185 28 28 / var(--tw-text-opacity, 1))
        }

        .focus\:border-transparent:focus {
            border-color: transparent
        }

        .focus\:outline-none:focus {
            outline: 2px solid transparent;
            outline-offset: 2px
        }

        .focus\:ring-2:focus {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)
        }

        .focus\:ring-indigo-500:focus {
            --tw-ring-opacity: 1;
            --tw-ring-color: rgb(99 102 241 / var(--tw-ring-opacity, 1))
        }

        .focus\:ring-offset-2:focus {
            --tw-ring-offset-width: 2px
        }

        @media (min-width: 640px) {
            .sm\:flex {
                display: flex
            }

            .sm\:hidden {
                display: none
            }

            .sm\:flex-1 {
                flex: 1 1 0%
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:p-6 {
                padding: 1.5rem
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }
        }

        @media (min-width: 768px) {
            .md\:block {
                display: block
            }

            .md\:inline-block {
                display: inline-block
            }

            .md\:hidden {
                display: none
            }

            .md\:w-64 {
                width: 16rem
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .md\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr))
            }

            .md\:grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr))
            }

            .md\:flex-row {
                flex-direction: row
            }

            .md\:items-center {
                align-items: center
            }

            .md\:justify-between {
                justify-content: space-between
            }

            .md\:space-y-0> :not([hidden])~ :not([hidden]) {
                --tw-space-y-reverse: 0;
                margin-top: calc(0px * calc(1 - var(--tw-space-y-reverse)));
                margin-bottom: calc(0px * var(--tw-space-y-reverse))
            }
        }

        @media (min-width: 1024px) {
            .lg\:col-span-2 {
                grid-column: span 2 / span 2
            }

            .lg\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr))
            }

            .lg\:grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr))
            }

            .lg\:p-8 {
                padding: 2rem
            }

            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }
    </style>
</head>

<body>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="sidebar bg-white border-r border-gray-200 hidden md:block transition-all duration-300 ease-in-out"
            style="width: 256px;">
            <div class="h-full flex flex-col">
                <!-- Logo and Toggle -->
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <div class="flex items-center sidebar-full">
                        <h1 class="text-xl font-bold text-gray-900">
                            <span class="text-indigo-600">Allpa</span>Soft
                        </h1>
                    </div>
                    <div class="sidebar-mini hidden">
                        <h1 class="text-xl font-bold text-indigo-600">A</h1>
                    </div>
                    <button id="sidebar-toggle-btn" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto py-4">
                    <ul class="space-y-1 px-3">
                        <!-- Dashboard - Visible para todos -->
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                data-target="dashboard-section">
                                <i class="fas fa-tachometer-alt w-5 h-5 text-indigo-600"></i>
                                <span class="ml-3 sidebar-text">Dashboard</span>
                            </a>
                        </li>

                        <!-- Facturas - Solo para Ventas y Administrador -->
                        @hasanyrole(['Ventas', 'Administrador'])
                            <li>
                                <a href="{{ route('admin.invoices.index') }}"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="invoices-section">
                                    <i class="fas fa-file-invoice w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3 sidebar-text">Facturas</span>
                                    @if (auth()->user()->hasRole('Ventas'))
                                        <span
                                            class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Ventas</span>
                                    @endif
                                </a>
                            </li>
                        @endhasanyrole

                        <!-- Clientes - Para Secretario, Ventas y Administrador -->
                        @hasanyrole(['Secretario', 'Ventas', 'Administrador'])
                            <li>
                                <a href="{{ route('admin.customers.index') }}"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="clients-section">
                                    <i class="fas fa-users w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3 sidebar-text">Clientes</span>
                                    @if (auth()->user()->hasRole('Secretario'))
                                        <span
                                            class="ml-auto bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Secretario</span>
                                    @endif
                                </a>
                            </li>
                        @endhasanyrole

                        <!-- Productos - Solo para Bodega y Administrador -->
                        @hasanyrole(['Bodega', 'Administrador'])
                            <li>
                                <a href="{{ route('admin.products.index') }}"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="products-section">
                                    <i class="fas fa-box w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3 sidebar-text">Productos</span>
                                    @if (auth()->user()->hasRole('Bodega'))
                                        <span
                                            class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Bodega</span>
                                    @endif
                                </a>
                            </li>
                        @endhasanyrole

                        <!-- Reportes - Para Secretario y Administrador -->
                        @hasanyrole(['Secretario', 'Administrador'])
                            <li>
                                <a href="{{ route('admin.reports.index') }}"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="reports-section">
                                    <i class="fas fa-chart-bar w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3 sidebar-text">Reportes</span>
                                </a>
                            </li>
                        @endhasanyrole

                        <!-- Sección de Configuración - Solo para Administrador -->
                        @hasrole('Administrador')
                            <li class="pt-4 mt-4 border-t border-gray-200 sidebar-full">
                                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Administración
                                </h3>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.index') }}"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="users-section">
                                    <i class="fas fa-users-cog w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3 sidebar-text">Usuarios</span>
                                    <span
                                        class="ml-auto bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Admin</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.activities.index') }}"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="activities-section">
                                    <i class="fas fa-history w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3 sidebar-text">Auditorías</span>
                                    <span
                                        class="ml-auto bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Admin</span>
                                </a>
                            </li>
                        @endhasrole

                        @hasrole('Pagos')
                            <li class="pt-4 mt-4 border-t border-gray-200 sidebar-full">
                                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Pagos
                                </h3>
                            </li>
                            <li>
                                <a href="{{ route('payments.index') }}"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="users-section">
                                    <i class="fas fa-users-cog w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3 sidebar-text">Pagos</span>
                                    <span
                                        class="ml-auto bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Admin</span>
                                </a>
                            </li>
                        @endhasrole


                        <li class="pt-4 mt-4 border-t border-gray-200 sidebar-full">
                            <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Personal
                            </h3>
                        </li>
                        <li>
                            <a href="/profile"
                                class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                data-target="profile-section">
                                <i class="fas fa-user-cog w-5 h-5 text-gray-500"></i>
                                <span class="ml-3 sidebar-text">Mi Perfil</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- User -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full"
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366F1&color=fff"
                                alt="User">
                        </div>
                        <div class="ml-3 sidebar-full">
                            <p class="text-sm font-medium text-gray-900">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                @if (Auth::user()->getRoleNames()->count() > 1)
                                    {{ Auth::user()->getRoleNames()->implode(', ') }}
                                @else
                                    {{ Auth::user()->getRoleNames()->first() ?? 'Sin rol' }}
                                @endif
                            </p>
                            @if (Auth::user()->getRoleNames()->count() > 1)
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @foreach (Auth::user()->getRoleNames() as $role)
                                        @if ($role === 'Administrador')
                                            <span
                                                class="bg-red-100 text-red-800 text-xs px-1 py-0.5 rounded">{{ $role }}</span>
                                        @elseif($role === 'Secretario')
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs px-1 py-0.5 rounded">{{ $role }}</span>
                                        @elseif($role === 'Bodega')
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs px-1 py-0.5 rounded">{{ $role }}</span>
                                        @elseif($role === 'Ventas')
                                            <span
                                                class="bg-green-100 text-green-800 text-xs px-1 py-0.5 rounded">{{ $role }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Mobile sidebar toggle -->
        <div class="md:hidden fixed bottom-4 right-4 z-50">
            <button id="sidebar-toggle" class="bg-indigo-600 text-white p-3 rounded-full shadow-lg">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Mobile sidebar -->
        <div id="mobile-sidebar" class="fixed inset-0 bg-gray-800 bg-opacity-50 z-40 hidden md:hidden">
            <div class="absolute top-0 left-0 h-full w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300"
                id="mobile-sidebar-panel">
                <!-- Mobile sidebar content (same as desktop) -->
                <div class="h-full flex flex-col">
                    <!-- Logo -->
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h1 class="text-xl font-bold text-gray-900">
                            <span class="text-indigo-600">Allpa</span>Soft
                        </h1>
                        <button id="close-sidebar" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Navigation (same as desktop) -->
                    <nav class="flex-1 overflow-y-auto py-4">
                        <ul class="space-y-1 px-3">
                            <li>
                                <a href="{{ route('dashboard') }}"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="dashboard-section">
                                    <i class="fas fa-tachometer-alt w-5 h-5 text-indigo-600"></i>
                                    <span class="ml-3">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.invoices.index') }}"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="invoices-section">
                                    <i class="fas fa-file-invoice w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3">Facturas</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.customers.index') }}"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="clients-section">
                                    <i class="fas fa-users w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3">Clientes</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.products.index') }}"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="products-section">
                                    <i class="fas fa-box w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3">Productos</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="reports-section">
                                    <i class="fas fa-chart-bar w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3">Reportes</span>
                                </a>
                            </li>

                            <li class="pt-4 mt-4 border-t border-gray-200">
                                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Configuración
                                </h3>
                            </li>
                            <li>
                                <a href="#"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="profile-section">

                                    <i class="fas fa-user-cog w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3">Perfil</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="sidebar-link nav-link flex items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="team-section">

                                    <i class="fas fa-users-cog w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3">Equipo</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="sidebar-link flex nav-link items-center px-4 py-3 text-gray-700 rounded-lg"
                                    data-target="config-section">

                                    <i class="fas fa-cog w-5 h-5 text-gray-500"></i>
                                    <span class="ml-3">Ajustes</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- User -->
                    <div class="p-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full"
                                    src="https://ui-avatars.com/api/?name=Juan+Perez&amp;background=6366F1&amp;color=fff"
                                    alt="User">
                            </div>
                            <div class="ml-3">


                                <p class="text-sm font-medium text-gray-900">
                                    {{ Auth::user()?->name ?? 'Invitado' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ Auth::user()?->getRoleNames()->first() ?? 'Sin rol' }}
                                </p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- Mobile menu button -->
                            <button class="md:hidden text-gray-500 hover:text-gray-700 mr-4" id="mobile-menu-button">
                                <i class="fas fa-bars"></i>
                            </button>

                            <h1 id="page-title" class="text-lg font-semibold text-gray-900">Facturas</h1>
                        </div>

                        <div class="flex items-center space-x-4">

                            <!-- User Menu -->
                            <div class="dropdown">
                                <button class="flex items-center space-x-2">
                                    <img class="h-8 w-8 rounded-full"
                                        src="https://ui-avatars.com/api/?name=Juan+Perez&amp;background=6366F1&amp;color=fff"
                                        alt="User">
                                    <span class="hidden md:inline-block text-sm font-medium text-gray-700">
                                        {{ Auth::user()?->name ?? 'Invitado' }}</span>
                                    <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                                </button>
                                <div class="dropdown-menu bg-white shadow-lg rounded-lg w-48 overflow-hidden">
                                    {{-- <a href="/profile"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 nav-link"
                                        data-target="profile-section">
                                        <i class="fas fa-user mr-2 text-gray-500"></i> Perfil
                                    </a> --}}
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2 text-gray-500"></i> Cerrar sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <!-- Dashboard Section -->

                {{ $slot }}

            </main>
        </div>
    </div>

    <!-- New Invoice Modal -->
    <div id="new-invoice-modal"
        class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div
                class="px-6 py-4 border-b border-gray-200 flex items-center justify-between sticky top-0 bg-white z-10">
                <h3 class="text-lg font-semibold text-gray-900">Nueva Factura</h3>
                <button id="close-invoice-modal" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-4">
                <form id="invoice-form">
                    <!-- Client Information -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Información del Cliente</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="client"
                                    class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                                <select id="client" name="client"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">Seleccionar cliente</option>
                                    <option value="1">Empresa ABC</option>
                                    <option value="2">Empresa XYZ</option>
                                    <option value="3">Empresa DEF</option>
                                    <option value="4">Empresa GHI</option>
                                    <option value="5">Empresa JKL</option>
                                </select>
                            </div>
                            <div>
                                <label for="new-client" class="block text-sm font-medium text-gray-700 mb-1">
                                    <span class="flex items-center">
                                        <span>¿Cliente nuevo?</span>
                                        <button type="button" id="toggle-new-client"
                                            class="ml-2 text-xs text-indigo-600 hover:text-indigo-800">
                                            Añadir nuevo cliente
                                        </button>
                                    </span>
                                </label>
                                <div id="new-client-fields" class="hidden space-y-3 mt-2">
                                    <input type="text" id="client-name" name="client-name"
                                        placeholder="Nombre del cliente"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <input type="email" id="client-email" name="client-email"
                                        placeholder="Email del cliente"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Details -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Detalles de la Factura</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="invoice-number"
                                    class="block text-sm font-medium text-gray-700 mb-1">Número de Factura</label>
                                <input type="text" id="invoice-number" name="invoice-number" value="#INV-006"
                                    readonly=""
                                    class="w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="issue-date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de
                                    Emisión</label>
                                <input type="date" id="issue-date" name="issue-date"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="due-date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de
                                    Vencimiento</label>
                                <input type="date" id="due-date" name="due-date"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-md font-medium text-gray-900">Productos / Servicios</h4>
                            <button type="button" id="add-item"
                                class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center">
                                <i class="fas fa-plus mr-1"></i> Añadir ítem
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Descripción</th>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Cantidad</th>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Precio Unitario</th>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Impuesto</th>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total</th>
                                        <th
                                            class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="invoice-items" class="divide-y divide-gray-200">
                                    <tr class="invoice-item">
                                        <td class="px-3 py-2">
                                            <input type="text" name="item-description[]" placeholder="Descripción"
                                                class="w-full rounded-md border border-gray-300 px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        </td>
                                        <td class="px-3 py-2">
                                            <input type="number" name="item-quantity[]" value="1"
                                                min="1"
                                                class="w-20 rounded-md border border-gray-300 px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent item-quantity">
                                        </td>
                                        <td class="px-3 py-2">
                                            <div class="flex items-center">
                                                <span class="text-gray-500 mr-1">S/</span>
                                                <input type="number" name="item-price[]" value="0.00"
                                                    min="0" step="0.01"
                                                    class="w-24 rounded-md border border-gray-300 px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent item-price">
                                            </div>
                                        </td>
                                        <td class="px-3 py-2">
                                            <select name="item-tax[]"
                                                class="rounded-md border border-gray-300 px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent item-tax">
                                                <option value="0">0%</option>
                                                <option value="18" selected="">18%</option>
                                                <option value="10">10%</option>
                                            </select>
                                        </td>
                                        <td class="px-3 py-2">
                                            <div class="flex items-center">
                                                <span class="text-gray-500 mr-1">S/</span>
                                                <span class="item-total">0.00</span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2">
                                            <button type="button"
                                                class="text-red-500 hover:text-red-700 remove-item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Totals -->
                    <div class="mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-end">
                                <div class="w-64">
                                    <div class="flex justify-between py-2">
                                        <span class="text-sm text-gray-600">Subtotal:</span>
                                        <div class="flex items-center">
                                            <span class="text-gray-500 mr-1">S/</span>
                                            <span id="subtotal">0.00</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between py-2">
                                        <span class="text-sm text-gray-600">IGV (18%):</span>
                                        <div class="flex items-center">
                                            <span class="text-gray-500 mr-1">S/</span>
                                            <span id="tax-total">0.00</span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between py-2 border-t border-gray-200">
                                        <span class="text-sm font-medium text-gray-700">Total:</span>
                                        <div class="flex items-center">
                                            <span class="text-gray-700 mr-1">S/</span>
                                            <span id="grand-total" class="font-medium">0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Información Adicional</h4>
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                            <textarea id="notes" name="notes" rows="3" placeholder="Añadir notas o términos de pago"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div
                class="px-6 py-4 border-t border-gray-200 flex items-center justify-end space-x-3 sticky bottom-0 bg-white z-10">
                <button id="cancel-invoice"
                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cancelar
                </button>
                <button id="save-invoice"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Guardar Factura
                </button>
            </div>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const mobileSidebarPanel = document.getElementById('mobile-sidebar-panel');
            const closeSidebar = document.getElementById('close-sidebar');

            // Desktop sidebar collapse functionality
            const sidebar = document.getElementById('sidebar');
            const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const sidebarFullElements = document.querySelectorAll('.sidebar-full');
            const sidebarMiniElements = document.querySelectorAll('.sidebar-mini');

            let sidebarCollapsed = false;

            sidebarToggleBtn.addEventListener('click', function() {
                sidebarCollapsed = !sidebarCollapsed;

                if (sidebarCollapsed) {
                    // Collapse sidebar
                    sidebar.style.width = '80px';
                    sidebarToggleBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';

                    // Hide text elements
                    sidebarTexts.forEach(el => {
                        el.classList.add('hidden');
                    });

                    // Hide full elements and show mini elements
                    sidebarFullElements.forEach(el => {
                        el.classList.add('hidden');
                    });

                    sidebarMiniElements.forEach(el => {
                        el.classList.remove('hidden');
                    });
                } else {
                    // Expand sidebar
                    sidebar.style.width = '256px';
                    sidebarToggleBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';

                    // Show text elements
                    sidebarTexts.forEach(el => {
                        el.classList.remove('hidden');
                    });

                    // Show full elements and hide mini elements
                    sidebarFullElements.forEach(el => {
                        el.classList.remove('hidden');
                    });

                    sidebarMiniElements.forEach(el => {
                        el.classList.add('hidden');
                    });
                }
            });

            // Mobile sidebar toggle
            sidebarToggle.addEventListener('click', function() {
                mobileSidebar.classList.remove('hidden');
                setTimeout(() => {
                    mobileSidebarPanel.classList.remove('-translate-x-full');
                }, 50);
            });

            closeSidebar.addEventListener('click', function() {
                mobileSidebarPanel.classList.add('-translate-x-full');
                setTimeout(() => {
                    mobileSidebar.classList.add('hidden');
                }, 300);
            });

            mobileSidebar.addEventListener('click', function(e) {
                if (e.target === mobileSidebar) {
                    mobileSidebarPanel.classList.add('-translate-x-full');
                    setTimeout(() => {
                        mobileSidebar.classList.add('hidden');
                    }, 300);
                }
            });

            // Navigation tabs
            const navLinks = document.querySelectorAll('.nav-link');
            const contentSections = document.querySelectorAll('.content-section');
            const pageTitle = document.getElementById('page-title');

            function activateTab(targetId) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    const icon = link.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-indigo-600');
                        icon.classList.add('text-gray-500');
                    }
                });

                navLinks.forEach(link => {
                    if (link.getAttribute('data-target') === targetId) {
                        link.classList.add('active');
                        const icon = link.querySelector('i');
                        if (icon) {
                            icon.classList.remove('text-gray-500');
                            icon.classList.add('text-indigo-600');
                        }
                    }
                });

                // Solo mostrar/ocultar secciones si estamos en la página de dashboard
                if (window.location.pathname === '/dashboard') {
                    contentSections.forEach(section => {
                        section.classList.remove('active');
                        if (section.id === targetId) {
                            section.classList.add('active');
                        }
                    });
                }

                if (pageTitle) {
                    const titles = {
                        'dashboard-section': 'Dashboard',
                        'invoices-section': 'Facturas',
                        'clients-section': 'Clientes',
                        'products-section': 'Productos',
                        'reports-section': 'Reportes',
                        'users-section': 'Gestión de Usuarios',
                        'activities-section': 'Auditorías',
                        'profile-section': 'Perfil',
                        'team-section': 'Equipo',
                        'config-section': 'Ajustes'
                    };
                    pageTitle.textContent = titles[targetId] || 'Dashboard';
                }
            }

            // Función para obtener el tab activo basado en la URL actual
            function getActiveTabFromUrl() {
                const currentPath = window.location.pathname;

                if (currentPath === '/dashboard') {
                    return 'dashboard-section';
                } else if (currentPath.includes('/admin/invoices')) {
                    return 'invoices-section';
                } else if (currentPath.includes('/admin/customers')) {
                    return 'clients-section';
                } else if (currentPath.includes('/admin/products')) {
                    return 'products-section';
                } else if (currentPath.includes('/admin/users')) {
                    return 'users-section';
                } else if (currentPath.includes('/admin/activities')) {
                    return 'activities-section';
                } else if (currentPath.includes('/admin/reports')) {
                    return 'reports-section';
                } else if (currentPath.includes('/profile')) {
                    return 'profile-section';
                }

                return 'dashboard-section'; // Default
            }

            // Función para actualizar el título basado en la URL
            function updatePageTitleFromUrl() {
                const currentPath = window.location.pathname;

                if (pageTitle) {
                    if (currentPath === '/dashboard') {
                        pageTitle.textContent = 'Dashboard';
                    } else if (currentPath.includes('/admin/invoices')) {
                        pageTitle.textContent = 'Facturas';
                    } else if (currentPath.includes('/admin/customers')) {
                        pageTitle.textContent = 'Clientes';
                    } else if (currentPath.includes('/admin/products')) {
                        pageTitle.textContent = 'Productos';
                    } else if (currentPath.includes('/admin/users')) {
                        pageTitle.textContent = 'Gestión de Usuarios';
                    } else if (currentPath.includes('/admin/activities')) {
                        pageTitle.textContent = 'Auditorías';
                    } else if (currentPath.includes('/admin/reports')) {
                        pageTitle.textContent = 'Reportes';
                    } else if (currentPath.includes('/profile')) {
                        pageTitle.textContent = 'Perfil';
                    }
                }
            }

            // Evento para cada link
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const targetId = this.getAttribute('data-target');
                    const href = this.getAttribute('href');

                    // Si estamos en dashboard y el link es para una sección SPA
                    if (window.location.pathname === '/dashboard' && targetId && [
                            'dashboard-section', 'reports-section', 'profile-section',
                            'team-section', 'config-section'
                        ].includes(targetId)) {
                        e.preventDefault();
                        activateTab(targetId);
                        return;
                    }

                    // Para otros enlaces, solo activar el estado visual pero permitir navegación
                    if (targetId) {
                        activateTab(targetId);
                    }
                });
            });

            // Al cargar, activar tab basado en URL actual
            const currentTab = getActiveTabFromUrl();
            activateTab(currentTab);
            updatePageTitleFromUrl();




            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                // Check if chart data is available (only on dashboard)
                const chartDataExists = typeof window.chartData !== 'undefined';
                const monthLabels = chartDataExists ? window.chartData.month_labels : ['Ene', 'Feb', 'Mar', 'Abr',
                    'May', 'Jun'
                ];
                const monthlyRevenue = chartDataExists ? window.chartData.monthly_revenue : [0, 0, 0, 0, 0, 0];

                const revenueChart = new Chart(revenueCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: monthLabels,
                        datasets: [{
                            label: 'Ingresos',
                            data: monthlyRevenue,
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            borderColor: 'rgba(79, 70, 229, 1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // Invoice Status Chart
            const statusCtx = document.getElementById('invoiceStatusChart');
            if (statusCtx) {
                // Check if chart data is available (only on dashboard)
                const chartDataExists = typeof window.chartData !== 'undefined';
                const statusData = chartDataExists ? window.chartData.invoice_status_data : {
                    paid: 0,
                    pending: 0,
                    overdue: 0
                };

                const statusChart = new Chart(statusCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Pagadas', 'Pendientes', 'Vencidas'],
                        datasets: [{
                            data: [statusData.paid, statusData.pending, statusData.overdue],
                            backgroundColor: [
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(245, 158, 11, 0.8)',
                                'rgba(239, 68, 68, 0.8)'
                            ],
                            borderColor: [
                                'rgba(16, 185, 129, 1)',
                                'rgba(245, 158, 11, 1)',
                                'rgba(239, 68, 68, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 20
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            }

            // Task checkboxes
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const taskText = this.nextElementSibling?.querySelector('p:first-child');
                    if (taskText && this.checked) {
                        taskText.classList.add('line-through', 'text-gray-400');
                    } else if (taskText) {
                        taskText.classList.remove('line-through', 'text-gray-400');
                    }
                });
            });

            // New Invoice Modal
            const newInvoiceBtn = document.getElementById('new-invoice-btn');
            const newInvoiceModal = document.getElementById('new-invoice-modal');
            const closeInvoiceModal = document.getElementById('close-invoice-modal');
            const cancelInvoice = document.getElementById('cancel-invoice');
            const saveInvoice = document.getElementById('save-invoice');
            const toggleNewClient = document.getElementById('toggle-new-client');
            const newClientFields = document.getElementById('new-client-fields');
            const addItemBtn = document.getElementById('add-item');
            const invoiceItems = document.getElementById('invoice-items');

            // Set today's date as default for issue date
            const today = new Date();
            const formattedDate = today.toISOString().substr(0, 10);
            document.getElementById('issue-date').value = formattedDate;

            // Set default due date (15 days from today)
            const dueDate = new Date();
            dueDate.setDate(today.getDate() + 15);
            document.getElementById('due-date').value = dueDate.toISOString().substr(0, 10);

            // Toggle new client fields
            toggleNewClient.addEventListener('click', function() {
                newClientFields.classList.toggle('hidden');
                if (!newClientFields.classList.contains('hidden')) {
                    document.getElementById('client-name').focus();
                }
            });

            // Open modal
            newInvoiceBtn.addEventListener('click', function() {
                newInvoiceModal.classList.remove('hidden');
                calculateTotals();
            });

            // Close modal
            function closeModal() {
                newInvoiceModal.classList.add('hidden');
            }

            closeInvoiceModal.addEventListener('click', closeModal);
            cancelInvoice.addEventListener('click', closeModal);

            // Close modal when clicking outside
            newInvoiceModal.addEventListener('click', function(e) {
                if (e.target === newInvoiceModal) {
                    closeModal();
                }
            });

            // Add new item row
            addItemBtn.addEventListener('click', function() {
                const newRow = document.createElement('tr');
                newRow.className = 'invoice-item';
                newRow.innerHTML = `
                    <td class="px-3 py-2">
                        <input type="text" name="item-description[]" placeholder="Descripción" class="w-full rounded-md border border-gray-300 px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </td>
                    <td class="px-3 py-2">
                        <input type="number" name="item-quantity[]" value="1" min="1" class="w-20 rounded-md border border-gray-300 px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent item-quantity">
                    </td>
                    <td class="px-3 py-2">
                        <div class="flex items-center">
                            <span class="text-gray-500 mr-1">S/</span>
                            <input type="number" name="item-price[]" value="0.00" min="0" step="0.01" class="w-24 rounded-md border border-gray-300 px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent item-price">
                        </div>
                    </td>
                    <td class="px-3 py-2">
                        <select name="item-tax[]" class="rounded-md border border-gray-300 px-3 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent item-tax">
                            <option value="0">0%</option>
                            <option value="18" selected>18%</option>
                            <option value="10">10%</option>
                        </select>
                    </td>
                    <td class="px-3 py-2">
                        <div class="flex items-center">
                            <span class="text-gray-500 mr-1">S/</span>
                            <span class="item-total">0.00</span>
                        </div>
                    </td>
                    <td class="px-3 py-2">
                        <button type="button" class="text-red-500 hover:text-red-700 remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;

                invoiceItems.appendChild(newRow);

                // Add event listeners to new row
                addItemEventListeners(newRow);
            });

            // Remove item row
            function handleRemoveItem(e) {
                const button = e.target.closest('.remove-item');
                if (!button) return;

                const row = button.closest('.invoice-item');

                // Don't remove if it's the only row
                if (document.querySelectorAll('.invoice-item').length > 1) {
                    row.remove();
                    calculateTotals();
                } else {
                    // Clear values instead of removing
                    const inputs = row.querySelectorAll('input');
                    inputs.forEach(input => {
                        if (input.type === 'number' && input.name.includes('quantity')) {
                            input.value = 1;
                        } else if (input.type === 'number') {
                            input.value = 0;
                        } else {
                            input.value = '';
                        }
                    });
                    row.querySelector('.item-total').textContent = '0.00';
                    calculateTotals();
                }
            }

            // Calculate item total
            function calculateItemTotal(row) {
                const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value) || 0;
                const taxRate = parseFloat(row.querySelector('.item-tax').value) || 0;

                const subtotal = quantity * price;
                const total = subtotal * (1 + taxRate / 100);

                row.querySelector('.item-total').textContent = total.toFixed(2);

                return {
                    subtotal,
                    tax: subtotal * (taxRate / 100),
                    total
                };
            }

            // Calculate all totals
            function calculateTotals() {
                const rows = document.querySelectorAll('.invoice-item');
                let subtotal = 0;
                let taxTotal = 0;
                let grandTotal = 0;

                rows.forEach(row => {
                    const itemTotals = calculateItemTotal(row);
                    subtotal += itemTotals.subtotal;
                    taxTotal += itemTotals.tax;
                    grandTotal += itemTotals.total;
                });

                document.getElementById('subtotal').textContent = subtotal.toFixed(2);
                document.getElementById('tax-total').textContent = taxTotal.toFixed(2);
                document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
            }

            // Add event listeners to item inputs
            function addItemEventListeners(row) {
                const quantityInput = row.querySelector('.item-quantity');
                const priceInput = row.querySelector('.item-price');
                const taxSelect = row.querySelector('.item-tax');
                const removeBtn = row.querySelector('.remove-item');

                quantityInput.addEventListener('input', calculateTotals);
                priceInput.addEventListener('input', calculateTotals);
                taxSelect.addEventListener('change', calculateTotals);
                removeBtn.addEventListener('click', handleRemoveItem);
            }

            // Add event listeners to initial row
            document.querySelectorAll('.invoice-item').forEach(row => {
                addItemEventListeners(row);
            });

            // Save invoice
            saveInvoice.addEventListener('click', function() {
                // Here you would normally send the data to the server
                // For this demo, we'll just close the modal and show a success message

                // Simple validation
                const client = document.getElementById('client').value;
                const clientName = document.getElementById('client-name').value;

                if (!client && !clientName) {
                    alert('Por favor seleccione un cliente o añada uno nuevo.');
                    return;
                }

                // Close modal
                closeModal();

                // Show success message (you could use a toast notification here)
                alert('Factura guardada con éxito!');
            });
        });
    </script>
    <script>
        (function() {
            function c() {
                var b = a.contentDocument || a.contentWindow.document;
                if (b) {
                    var d = b.createElement('script');
                    d.innerHTML =
                        "window.__CF$cv$params={r:'95cccd55f5b9325a',t:'MTc1MjExNjMzNS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
                    b.getElementsByTagName('head')[0].appendChild(d)
                }
            }
            if (document.body) {
                var a = document.createElement('iframe');
                a.height = 1;
                a.width = 1;
                a.style.position = 'absolute';
                a.style.top = 0;
                a.style.left = 0;
                a.style.border = 'none';
                a.style.visibility = 'hidden';
                document.body.appendChild(a);
                if ('loading' !== document.readyState) c();
                else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c);
                else {
                    var e = document.onreadystatechange || function() {};
                    document.onreadystatechange = function(b) {
                        e(b);
                        'loading' !== document.readyState && (document.onreadystatechange = e, c())
                    }
                }
            }
        })();
    </script><iframe height="1" width="1"
        style="position: absolute; top: 0px; left: 0px; border: none; visibility: hidden;"></iframe>

</body>

</html>
