@once
    @push('styles')
        <style>
            .assessment-page {
                min-height: 70vh;
            }

            .assessment-header {
                gap: 1rem;
            }

            .assessment-title {
                color: #25344d;
                line-height: 1.35;
            }

            .assessment-timer {
                min-width: 80px;
                border-radius: 6px;
                font-weight: 500;
            }

            .assessment-nav-panel {
                border-right: 1px solid #e9edf3;
            }

            .assessment-question-grid {
                display: grid;
                grid-template-columns: repeat(5, minmax(44px, 1fr));
                gap: .55rem;
                margin-bottom: 1rem;
            }

            .assessment-question-grid .nav-button {
                min-height: 36px;
                border-radius: 6px;
                font-weight: 500;
            }

            .assessment-question-grid .nav-button.is-active {
                background: #1f344d;
                border-color: #1f344d;
                color: #fff;
            }

            .assessment-question-grid .nav-button.is-answered:not(.is-active) {
                background: #eaf6ff;
                border-color: #23a6ff;
                color: #1598ef;
            }

            .assessment-question-text {
                color: #141f2f;
                line-height: 1.5;
                margin-bottom: 1.1rem;
            }

            .assessment-answer {
                display: flex;
                align-items: flex-start;
                gap: .45rem;
                color: #62718a;
                line-height: 1.4;
            }

            .assessment-answer .form-check-input {
                flex: 0 0 auto;
                margin-left: 0;
                margin-top: .2rem;
            }

            .assessment-actions {
                gap: .75rem;
                padding-top: .5rem;
            }

            @media (max-width: 767.98px) {
                .assessment-page {
                    padding-top: 1rem !important;
                    padding-bottom: 1.5rem !important;
                }

                .assessment-page .container {
                    padding-left: 1.1rem;
                    padding-right: 1.1rem;
                }

                .assessment-content {
                    margin-left: 0;
                    margin-right: 0;
                }

                .assessment-header {
                    align-items: center !important;
                    margin-bottom: 1rem !important;
                }

                .assessment-title {
                    font-size: 1rem;
                    max-width: calc(100% - 96px);
                }

                .assessment-timer {
                    padding: .45rem .65rem !important;
                }

                .assessment-content {
                    padding-top: 1rem !important;
                    row-gap: 0;
                }

                .assessment-nav-panel {
                    border-right: 0;
                    border-bottom: 1px solid #edf1f6;
                    padding-right: 0 !important;
                    padding-bottom: 1.15rem;
                    margin-bottom: 1.35rem;
                }

                .assessment-question-panel {
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                }

                .assessment-question-grid {
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                    gap: .6rem;
                    margin-bottom: 0;
                }

                .assessment-question-grid .nav-button {
                    min-width: 0;
                    min-height: 32px;
                    padding: .32rem .25rem;
                    font-size: .82rem;
                }

                .assessment-question-text {
                    font-size: .88rem;
                    margin-bottom: 1.3rem;
                    padding-left: .15rem;
                    padding-right: .15rem;
                }

                .assessment-answer {
                    font-size: .84rem;
                    margin-bottom: .85rem !important;
                    padding-left: 1.25rem;
                    padding-right: .25rem;
                }

                .assessment-actions {
                    justify-content: center !important;
                    align-items: center !important;
                    margin-top: 1.7rem !important;
                    gap: .75rem;
                    padding-bottom: .45rem;
                }

                .assessment-actions #nextContainer {
                    align-items: center;
                }

                .assessment-actions #submitWrapper {
                    margin-top: 0 !important;
                }

                .assessment-actions .btn {
                    font-size: .82rem;
                    min-width: 142px;
                    min-height: 38px;
                    padding: .6rem .8rem;
                }
            }
        </style>
    @endpush
@endonce
