<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Facturación Web - AllpaSoft</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-shadow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            border: 2px solid #667eea;
            color: #667eea;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .section-padding {
            padding: 5rem 0;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
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

        .visible {
            visibility: visible
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

        .inset-0 {
            inset: 0px
        }

        .-top-4 {
            top: -1rem
        }

        .left-1\/2 {
            left: 50%
        }

        .top-0 {
            top: 0px
        }

        .z-50 {
            z-index: 50
        }

        .mx-4 {
            margin-left: 1rem;
            margin-right: 1rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .mb-16 {
            margin-bottom: 4rem
        }

        .mb-2 {
            margin-bottom: 0.5rem
        }

        .mb-4 {
            margin-bottom: 1rem
        }

        .mb-6 {
            margin-bottom: 1.5rem
        }

        .mb-8 {
            margin-bottom: 2rem
        }

        .mr-2 {
            margin-right: 0.5rem
        }

        .mt-1 {
            margin-top: 0.25rem
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

        .h-16 {
            height: 4rem
        }

        .h-20 {
            height: 5rem
        }

        .h-4 {
            height: 1rem
        }

        .h-5 {
            height: 1.25rem
        }

        .h-6 {
            height: 1.5rem
        }

        .h-8 {
            height: 2rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .w-10 {
            width: 2.5rem
        }

        .w-12 {
            width: 3rem
        }

        .w-16 {
            width: 4rem
        }

        .w-20 {
            width: 5rem
        }

        .w-4 {
            width: 1rem
        }

        .w-5 {
            width: 1.25rem
        }

        .w-6 {
            width: 1.5rem
        }

        .w-8 {
            width: 2rem
        }

        .w-full {
            width: 100%
        }

        .max-w-2xl {
            max-width: 42rem
        }

        .max-w-3xl {
            max-width: 48rem
        }

        .max-w-7xl {
            max-width: 80rem
        }

        .max-w-md {
            max-width: 28rem
        }

        .flex-1 {
            flex: 1 1 0%
        }

        .flex-shrink-0 {
            flex-shrink: 0
        }

        .-translate-x-1\/2 {
            --tw-translate-x: -50%;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
        }

        .transform {
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))
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

        .justify-center {
            justify-content: center
        }

        .justify-between {
            justify-content: space-between
        }

        .gap-12 {
            gap: 3rem
        }

        .gap-4 {
            gap: 1rem
        }

        .gap-6 {
            gap: 1.5rem
        }

        .gap-8 {
            gap: 2rem
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

        .space-y-6> :not([hidden])~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(1.5rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(1.5rem * var(--tw-space-y-reverse))
        }

        .overflow-hidden {
            overflow: hidden
        }

        .rounded-full {
            border-radius: 9999px
        }

        .rounded-lg {
            border-radius: 0.5rem
        }

        .rounded-xl {
            border-radius: 0.75rem
        }

        .border {
            border-width: 1px
        }

        .border-2 {
            border-width: 2px
        }

        .border-b {
            border-bottom-width: 1px
        }

        .border-l-4 {
            border-left-width: 4px
        }

        .border-t {
            border-top-width: 1px
        }

        .border-gray-200 {
            --tw-border-opacity: 1;
            border-color: rgb(229 231 235 / var(--tw-border-opacity, 1))
        }

        .border-gray-300 {
            --tw-border-opacity: 1;
            border-color: rgb(209 213 219 / var(--tw-border-opacity, 1))
        }

        .border-gray-600 {
            --tw-border-opacity: 1;
            border-color: rgb(75 85 99 / var(--tw-border-opacity, 1))
        }

        .border-gray-700 {
            --tw-border-opacity: 1;
            border-color: rgb(55 65 81 / var(--tw-border-opacity, 1))
        }

        .border-green-500 {
            --tw-border-opacity: 1;
            border-color: rgb(34 197 94 / var(--tw-border-opacity, 1))
        }

        .border-indigo-500 {
            --tw-border-opacity: 1;
            border-color: rgb(99 102 241 / var(--tw-border-opacity, 1))
        }

        .border-red-500 {
            --tw-border-opacity: 1;
            border-color: rgb(239 68 68 / var(--tw-border-opacity, 1))
        }

        .border-white {
            --tw-border-opacity: 1;
            border-color: rgb(255 255 255 / var(--tw-border-opacity, 1))
        }

        .border-yellow-500 {
            --tw-border-opacity: 1;
            border-color: rgb(234 179 8 / var(--tw-border-opacity, 1))
        }

        .bg-gray-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(249 250 251 / var(--tw-bg-opacity, 1))
        }

        .bg-black {
            --tw-bg-opacity: 1;
            background-color: rgb(0 0 0 / var(--tw-bg-opacity, 1))
        }

        .bg-blue-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(219 234 254 / var(--tw-bg-opacity, 1))
        }

        .bg-blue-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(59 130 246 / var(--tw-bg-opacity, 1))
        }

        .bg-gray-700 {
            --tw-bg-opacity: 1;
            background-color: rgb(55 65 81 / var(--tw-bg-opacity, 1))
        }

        .bg-gray-800 {
            --tw-bg-opacity: 1;
            background-color: rgb(31 41 55 / var(--tw-bg-opacity, 1))
        }

        .bg-gray-900 {
            --tw-bg-opacity: 1;
            background-color: rgb(17 24 39 / var(--tw-bg-opacity, 1))
        }

        .bg-green-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(220 252 231 / var(--tw-bg-opacity, 1))
        }

        .bg-green-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(240 253 244 / var(--tw-bg-opacity, 1))
        }

        .bg-green-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(34 197 94 / var(--tw-bg-opacity, 1))
        }

        .bg-indigo-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(224 231 255 / var(--tw-bg-opacity, 1))
        }

        .bg-indigo-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(99 102 241 / var(--tw-bg-opacity, 1))
        }

        .bg-indigo-600 {
            --tw-bg-opacity: 1;
            background-color: rgb(79 70 229 / var(--tw-bg-opacity, 1))
        }

        .bg-orange-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(255 237 213 / var(--tw-bg-opacity, 1))
        }

        .bg-purple-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(243 232 255 / var(--tw-bg-opacity, 1))
        }

        .bg-purple-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(168 85 247 / var(--tw-bg-opacity, 1))
        }

        .bg-red-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(254 226 226 / var(--tw-bg-opacity, 1))
        }

        .bg-red-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(254 242 242 / var(--tw-bg-opacity, 1))
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1))
        }

        .bg-yellow-100 {
            --tw-bg-opacity: 1;
            background-color: rgb(254 249 195 / var(--tw-bg-opacity, 1))
        }

        .bg-yellow-50 {
            --tw-bg-opacity: 1;
            background-color: rgb(254 252 232 / var(--tw-bg-opacity, 1))
        }

        .bg-opacity-50 {
            --tw-bg-opacity: 0.5
        }

        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops))
        }

        .from-blue-50 {
            --tw-gradient-from: #eff6ff var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(239 246 255 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-green-400 {
            --tw-gradient-from: #4ade80 var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(74 222 128 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-green-50 {
            --tw-gradient-from: #f0fdf4 var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(240 253 244 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-indigo-50 {
            --tw-gradient-from: #eef2ff var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(238 242 255 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .from-purple-50 {
            --tw-gradient-from: #faf5ff var(--tw-gradient-from-position);
            --tw-gradient-to: rgb(250 245 255 / 0) var(--tw-gradient-to-position);
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to)
        }

        .to-blue-500 {
            --tw-gradient-to: #3b82f6 var(--tw-gradient-to-position)
        }

        .to-cyan-50 {
            --tw-gradient-to: #ecfeff var(--tw-gradient-to-position)
        }

        .to-emerald-50 {
            --tw-gradient-to: #ecfdf5 var(--tw-gradient-to-position)
        }

        .to-indigo-50 {
            --tw-gradient-to: #eef2ff var(--tw-gradient-to-position)
        }

        .to-purple-50 {
            --tw-gradient-to: #faf5ff var(--tw-gradient-to-position)
        }

        .p-4 {
            padding: 1rem
        }

        .p-8 {
            padding: 2rem
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

        .px-8 {
            padding-left: 2rem;
            padding-right: 2rem
        }

        .py-1 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem
        }

        .py-12 {
            padding-top: 3rem;
            padding-bottom: 3rem
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem
        }

        .py-24 {
            padding-top: 6rem;
            padding-bottom: 6rem
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem
        }

        .pt-16 {
            padding-top: 4rem
        }

        .text-left {
            text-align: left
        }

        .text-center {
            text-align: center
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem
        }

        .text-3xl {
            font-size: 1.875rem;
            line-height: 2.25rem
        }

        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem
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

        .font-bold {
            font-weight: 700
        }

        .font-medium {
            font-weight: 500
        }

        .font-semibold {
            font-weight: 600
        }

        .text-blue-600 {
            --tw-text-opacity: 1;
            color: rgb(37 99 235 / var(--tw-text-opacity, 1))
        }

        .text-gray-300 {
            --tw-text-opacity: 1;
            color: rgb(209 213 219 / var(--tw-text-opacity, 1))
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

        .text-green-500 {
            --tw-text-opacity: 1;
            color: rgb(34 197 94 / var(--tw-text-opacity, 1))
        }

        .text-green-600 {
            --tw-text-opacity: 1;
            color: rgb(22 163 74 / var(--tw-text-opacity, 1))
        }

        .text-green-800 {
            --tw-text-opacity: 1;
            color: rgb(22 101 52 / var(--tw-text-opacity, 1))
        }

        .text-indigo-100 {
            --tw-text-opacity: 1;
            color: rgb(224 231 255 / var(--tw-text-opacity, 1))
        }

        .text-indigo-200 {
            --tw-text-opacity: 1;
            color: rgb(199 210 254 / var(--tw-text-opacity, 1))
        }

        .text-indigo-600 {
            --tw-text-opacity: 1;
            color: rgb(79 70 229 / var(--tw-text-opacity, 1))
        }

        .text-orange-600 {
            --tw-text-opacity: 1;
            color: rgb(234 88 12 / var(--tw-text-opacity, 1))
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

        .text-red-800 {
            --tw-text-opacity: 1;
            color: rgb(153 27 27 / var(--tw-text-opacity, 1))
        }

        .text-white {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity, 1))
        }

        .text-yellow-800 {
            --tw-text-opacity: 1;
            color: rgb(133 77 14 / var(--tw-text-opacity, 1))
        }

        .shadow-sm {
            --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .shadow-lg {
            --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)
        }

        .transition-colors {
            transition-property: color, background-color, border-color, fill, stroke, -webkit-text-decoration-color;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, -webkit-text-decoration-color;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        .hover\:bg-gray-50:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(249 250 251 / var(--tw-bg-opacity, 1))
        }

        .hover\:bg-white:hover {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity, 1))
        }

        .hover\:text-gray-600:hover {
            --tw-text-opacity: 1;
            color: rgb(75 85 99 / var(--tw-text-opacity, 1))
        }

        .hover\:text-indigo-600:hover {
            --tw-text-opacity: 1;
            color: rgb(79 70 229 / var(--tw-text-opacity, 1))
        }

        .hover\:text-indigo-800:hover {
            --tw-text-opacity: 1;
            color: rgb(55 48 163 / var(--tw-text-opacity, 1))
        }

        .focus\:border-transparent:focus {
            border-color: transparent
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

        @media (min-width: 640px) {
            .sm\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .sm\:flex-row {
                flex-direction: row
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }
        }

        @media (min-width: 768px) {
            .md\:col-span-2 {
                grid-column: span 2 / span 2
            }

            .md\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr))
            }

            .md\:grid-cols-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr))
            }

            .md\:text-6xl {
                font-size: 3.75rem;
                line-height: 1
            }
        }

        @media (min-width: 1024px) {
            .lg\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }

            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200 fixed w-full top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="#home" class="text-2xl font-bold text-gray-900">
                            <span class="text-indigo-600">Allpa</span>Soft
                        </a>
                    </div>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="btn-primary text-white px-4 py-2 rounded-lg font-medium text-sm">
                            Ir al Panel
                        </a>
                    @endauth

                    @guest
                        <a href="#login" class="btn-secondary px-4 py-2 rounded-lg font-medium text-sm">
                            Iniciar sesión
                        </a>
                        {{-- <a href="#register" class="btn-primary text-white px-4 py-2 rounded-lg font-medium text-sm">
                            Registrarse
                        </a> --}}
                    @endguest
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 pt-16">
        <!-- Hero Section -->
        <section id="home" class="relative overflow-hidden">
            <div class="gradient-bg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                    <div class="text-center">
                        <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                            Sistema de Facturación
                            <span class="block text-indigo-200">Profesional</span>
                        </h1>
                        <p class="text-xl text-indigo-100 mb-8 max-w-3xl mx-auto">
                            Gestiona tus facturas, clientes y reportes de manera eficiente con nuestra plataforma web
                            moderna y segura.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            @auth
                                <a href="{{ route('dashboard') }}"
                                    class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold text-lg hover:bg-gray-50 transition-colors">
                                    Ir al Panel
                                </a>
                            @endauth

                            @guest
                                <a href="#features"
                                    class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold text-lg hover:bg-gray-50 transition-colors">
                                    Conocer Características
                                </a>
                            @endguest
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in visible">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Todo lo que necesitas para facturar
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Una solución completa para gestionar tu negocio de manera profesional
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="text-center p-8 card-shadow rounded-xl bg-white fade-in visible">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Facturación Rápida</h3>
                        <p class="text-gray-600">
                            Crea facturas profesionales en segundos con nuestro editor intuitivo y plantillas
                            personalizables.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="text-center p-8 card-shadow rounded-xl bg-white fade-in visible">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Gestión de Clientes</h3>
                        <p class="text-gray-600">
                            Mantén organizados todos tus clientes con historial completo de transacciones y datos de
                            contacto.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="text-center p-8 card-shadow rounded-xl bg-white fade-in visible">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Reportes Detallados</h3>
                        <p class="text-gray-600">
                            Analiza el rendimiento de tu negocio con reportes completos y gráficos interactivos.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="text-center p-8 card-shadow rounded-xl bg-white fade-in visible">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Gestión de Facturas</h3>
                        <p class="text-gray-600">
                            Controla el estado de todas tus facturas: pendientes, pagadas, vencidas.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="text-center p-8 card-shadow rounded-xl bg-white fade-in visible">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Roles para Equipos</h3>
                        <p class="text-gray-600">
                            Asigna permisos específicos a cada miembro: administrador, contador, vendedor. Control total
                            de accesos.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="text-center p-8 card-shadow rounded-xl bg-white fade-in visible">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Seguridad Avanzada</h3>
                        <p class="text-gray-600">
                            Protección de datos con encriptación y autenticación de usuarios.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Invoice Management Section -->
        <section id="invoice-management" class="section-padding bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="fade-in visible">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">
                            Gestión Completa de Facturas
                        </h2>
                        <p class="text-lg text-gray-600 mb-8">
                            Controla todo el ciclo de vida de tus facturas desde un solo lugar. Desde la creación hasta
                            el cobro.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-1">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Estados en Tiempo Real</h4>
                                    <p class="text-gray-600">Visualiza qué facturas están pendientes, pagadas o
                                        vencidas</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-1">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Recordatorios Automáticos</h4>
                                    <p class="text-gray-600">Envía recordatorios de pago automáticamente por email</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-1">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Historial Completo</h4>
                                    <p class="text-gray-600">Accede al historial completo de pagos y comunicaciones</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fade-in visible">
                        <div class="bg-white p-8 rounded-xl card-shadow">
                            <div class="space-y-4">
                                <div
                                    class="flex items-center justify-between p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                                    <div>
                                        <p class="font-semibold text-gray-900">Factura #001</p>
                                        <p class="text-sm text-gray-600">Cliente: Empresa ABC</p>
                                    </div>
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Pagada</span>
                                </div>
                                <div
                                    class="flex items-center justify-between p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                                    <div>
                                        <p class="font-semibold text-gray-900">Factura #002</p>
                                        <p class="text-sm text-gray-600">Cliente: Empresa XYZ</p>
                                    </div>
                                    <span
                                        class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Pendiente</span>
                                </div>
                                <div
                                    class="flex items-center justify-between p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                                    <div>
                                        <p class="font-semibold text-gray-900">Factura #003</p>
                                        <p class="text-sm text-gray-600">Cliente: Empresa DEF</p>
                                    </div>
                                    <span
                                        class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">Vencida</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Roles Section -->
        <section id="team-roles" class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in visible">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Roles y Permisos para tu Equipo
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Asigna roles específicos a cada miembro de tu equipo y controla exactamente qué puede hacer cada
                        uno
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Admin Role -->
                    <div
                        class="text-center p-8 card-shadow rounded-xl bg-gradient-to-br from-purple-50 to-indigo-50 fade-in visible">
                        <div
                            class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Administrador</h3>
                        <ul class="text-left space-y-2 text-gray-600">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Acceso completo
                                al sistema</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Gestión de
                                usuarios y roles</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Configuración del
                                sistema</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Reportes
                                financieros</li>
                        </ul>
                    </div>

                    <!-- Accountant Role -->
                    <div
                        class="text-center p-8 card-shadow rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 fade-in visible">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Contador</h3>
                        <ul class="text-left space-y-2 text-gray-600">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Crear y editar
                                facturas</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Ver todos los
                                reportes</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Gestión de
                                clientes</li>
                            <li class="flex items-center"><span class="text-red-500 mr-2">✗</span> Configuración del
                                sistema</li>
                        </ul>
                    </div>

                    <!-- Sales Role -->
                    <div
                        class="text-center p-8 card-shadow rounded-xl bg-gradient-to-br from-blue-50 to-cyan-50 fade-in visible">
                        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Vendedor</h3>
                        <ul class="text-left space-y-2 text-gray-600">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Crear facturas
                                básicas</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Ver sus propias
                                ventas</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Gestión limitada
                                de clientes</li>
                            <li class="flex items-center"><span class="text-red-500 mr-2">✗</span> Reportes
                                financieros</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Security Section -->
        <section id="security" class="section-padding bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="fade-in visible">
                        <h2 class="text-3xl font-bold mb-6">
                            Seguridad de Nivel Empresarial
                        </h2>
                        <p class="text-lg text-gray-300 mb-8">
                            Protegemos tu información financiera con los más altos estándares de seguridad de la
                            industria.
                        </p>
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-300">Encriptación de datos sensibles 256-bit</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-300">Potección de rutas por middleware</span>
                            </div>
                        </div>
                    </div>
                    <div class="fade-in visible">
                        <div class="bg-gray-800 p-8 rounded-xl border border-gray-700">
                            <div class="flex items-center justify-center mb-6">
                                <div
                                    class="w-20 h-20 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-semibold text-center mb-4">Certificado de Seguridad</h3>
                            <p class="text-gray-400 text-center text-sm">
                                Nuestros servidores están protegidos y cumplen
                                con todos los estándares internacionales de seguridad.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="section-padding bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 fade-in visible">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Planes que se Adaptan a tu Negocio
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Desde emprendedores hasta grandes empresas, tenemos el plan perfecto para ti
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Basic Plan -->
                    <div class="bg-white p-8 rounded-xl card-shadow border-2 border-gray-200 fade-in visible">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Básico</h3>
                            <div class="mb-6">
                                <span class="text-4xl font-bold text-gray-900">$29</span>
                                <span class="text-gray-600">/mes</span>
                            </div>
                            <ul class="text-left space-y-3 mb-8">
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Hasta 100
                                    facturas/mes</li>
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> 3 usuarios
                                </li>
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Reportes
                                    básicos</li>
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Soporte por
                                    email</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Professional Plan -->
                    <div
                        class="bg-white p-8 rounded-xl card-shadow border-2 border-indigo-500 relative fade-in visible">
                        <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                            <span class="bg-indigo-500 text-white px-4 py-1 rounded-full text-sm font-medium">Más
                                Popular</span>
                        </div>
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Profesional</h3>
                            <div class="mb-6">
                                <span class="text-4xl font-bold text-gray-900">$79</span>
                                <span class="text-gray-600">/mes</span>
                            </div>
                            <ul class="text-left space-y-3 mb-8">
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Facturas
                                    ilimitadas</li>
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> 10 usuarios
                                </li>
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Reportes
                                    avanzados</li>
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Soporte
                                    prioritario</li>
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> API
                                    integración</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Enterprise Plan -->
                    <div class="bg-white p-8 rounded-xl card-shadow border-2 border-gray-200 fade-in visible">
                        <div class="text-center">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Empresarial</h3>
                            <div class="mb-6">
                                <span class="text-4xl font-bold text-gray-900">$199</span>
                                <span class="text-gray-600">/mes</span>
                            </div>
                            <ul class="text-left space-y-3 mb-8">
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Todo lo del
                                    plan Pro</li>
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Usuarios
                                    ilimitados</li>
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span>
                                    Personalización completa</li>
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Soporte 24/7
                                </li>
                                <li class="flex items-center"><span class="text-green-500 mr-2">✓</span> Gerente de
                                    cuenta</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    

       
        <!-- Login Modal -->
        <div id="login" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white p-8 rounded-xl max-w-md w-full mx-4">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Iniciar Sesión</h3>
                    <button onclick="closeModal('login')" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                @if (session('status'))
                    <div class="mb-4 text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <div id="login-errors" class="mb-4 text-sm text-red-600 hidden"></div>


                <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input id="email" name="email" type="email" required autofocus
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                        <input id="password" name="password" type="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                    <div class="flex items-center justify-between">
                        <label for="remember" class="inline-flex items-center">
                            <input type="checkbox" name="remember" id="remember"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full btn-primary text-white px-6 py-3 rounded-lg font-semibold">
                        Iniciar Sesión
                    </button>
                </form>

                {{-- <p class="text-center text-gray-600 mt-4">
                    ¿No tienes cuenta? <a href="#register" onclick="closeModal('login')"
                        class="text-indigo-600 hover:text-indigo-800">Regístrate</a>
                </p> --}}
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="md:col-span-2">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        <span class="text-indigo-600">Allpa</span>Soft
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Desarrollamos soluciones tecnológicas innovadoras para impulsar el crecimiento de tu negocio.
                    </p>
                    <p class="text-sm text-gray-500">
                        © 2025 AllpaSoft. Todos los derechos reservados.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Enlaces Rápidos</h4>
                    <ul class="space-y-2">
                        <li><a href="#features"
                                class="text-gray-600 hover:text-indigo-600 transition-colors">Características</a></li>
                        <li><a href="#pricing"
                                class="text-gray-600 hover:text-indigo-600 transition-colors">Precios</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Contacto</h4>
                    <ul class="space-y-2">
                        <li class="text-gray-600">info@allpasoft.com</li>
                        <li class="text-gray-600">+593 961 979691</li>
                        <li class="text-gray-600">Quito, Ecuador</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginForm = document.getElementById('login-form');
            const errorContainer = document.getElementById('login-errors');

            if (loginForm) {
                loginForm.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const formData = new FormData(loginForm);
                    errorContainer.classList.add('hidden');
                    errorContainer.innerHTML = '';

                    try {
                        const response = await fetch(loginForm.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': formData.get('_token')
                            },
                            body: formData
                        });

                        if (response.ok) {
                            const redirectUrl = new URLSearchParams(window.location.search).get(
                                'redirect') || '/dashboard';
                            window.location.href = redirectUrl;
                        } else if (response.status === 422) {
                            const data = await response.json();
                            const errors = data.errors;

                            let list = '<ul class="list-disc list-inside">';
                            for (const messages of Object.values(errors)) {
                                for (const msg of messages) {
                                    list += `<li>${msg}</li>`;
                                }
                            }
                            list += '</ul>';

                            errorContainer.innerHTML = list;
                            errorContainer.classList.remove('hidden');
                        } else {
                            errorContainer.innerHTML = 'Error al iniciar sesión. Intenta nuevamente.';
                            errorContainer.classList.remove('hidden');
                        }
                    } catch (err) {
                        console.error(err);
                        errorContainer.innerHTML = 'Ocurrió un error de red o servidor.';
                        errorContainer.classList.remove('hidden');
                    }
                });
            }
        });


        // Smooth scrolling for anchor links
        document.addEventListener('DOMContentLoaded', function() {
            // Handle anchor links
            const links = document.querySelectorAll('a[href^="#"]');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        // Check if it's a modal
                        if (targetId === 'login') {
                            openModal(targetId);
                        } else {
                            // Smooth scroll to section
                            const headerHeight = 80;
                            const targetPosition = targetElement.offsetTop - headerHeight;
                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });

            // Fade in animation on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            // Observe all fade-in elements
            document.querySelectorAll('.fade-in').forEach(el => {
                observer.observe(el);
            });

            // Header scroll effect
            window.addEventListener('scroll', function() {
                const header = document.querySelector('header');
                if (window.scrollY > 100) {
                    header.classList.add('shadow-lg');
                } else {
                    header.classList.remove('shadow-lg');
                }
            });

            // Form submissions
            const forms = document.querySelectorAll('form.client-only');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('¡Gracias por tu interés! Te contactaremos pronto.');
                });
            });
        });

        // Modal functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
                const modalId = e.target.id;
                closeModal(modalId);
            }
        });
    </script>
    <script>
        (function() {
            function c() {
                var b = a.contentDocument || a.contentWindow.document;
                if (b) {
                    var d = b.createElement('script');
                    d.innerHTML =
                        "window.__CF$cv$params={r:'95cc705bf37c9afb',t:'MTc1MjExMjUyNy4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
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
