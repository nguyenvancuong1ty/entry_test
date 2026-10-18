@props([
    'id' => 'common-global-modal',
    'title' => '確認',
    'subtitle' => '',
    'type' => 'danger', // danger | warning | info | success
    'confirmText' => 'OK',
    'cancelText' => 'キャンセル',
    'isGlobal' => false,
])

@php
    $iconMap = [
        'danger' => '⚠️',
        'warning' => '🔔',
        'info' => 'ℹ️',
        'success' => '✓',
    ];
    $icon = $iconMap[$type] ?? '⚠️';
@endphp

<div id="{{ $id }}" class="common-modal-backdrop" aria-hidden="true" style="display: none;">
    <div class="common-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title">
        <div class="common-modal-header">
            <div class="common-modal-icon-wrapper {{ $type }}" id="{{ $id }}-icon-wrapper">
                <span class="common-modal-icon" id="{{ $id }}-icon">{{ $icon }}</span>
            </div>
            <div class="common-modal-header-text">
                <h3 id="{{ $id }}-title" class="common-modal-title">{{ $title }}</h3>
                <p id="{{ $id }}-subtitle" class="common-modal-subtitle" @if(empty($subtitle)) style="display: none;" @endif>{{ $subtitle }}</p>
            </div>
            <button type="button" class="common-modal-close" data-modal-close aria-label="閉じる">×</button>
        </div>

        <div class="common-modal-body" id="{{ $id }}-body">
            @if(isset($slot) && !$slot->isEmpty())
                {{ $slot }}
            @else
                <p id="{{ $id }}-message" class="common-modal-message">本当に削除しますか？</p>
                <p id="{{ $id }}-target" class="common-modal-target" style="display: none;"></p>
            @endif
        </div>

        <div class="common-modal-footer">
            @if(isset($footer))
                {{ $footer }}
            @else
                <button type="button" class="btn-modal btn-modal-cancel" data-modal-cancel>{{ $cancelText }}</button>
                <button type="button" class="btn-modal btn-modal-confirm {{ $type }}" data-modal-confirm>{{ $confirmText }}</button>
            @endif
        </div>
    </div>
</div>

@if ($isGlobal || $id === 'common-global-modal')
    <script>
        (function () {
            if (window.CommonModal) return;

            const modalEl = document.getElementById('{{ $id }}');
            if (!modalEl) return;

            const titleEl = document.getElementById('{{ $id }}-title');
            const subtitleEl = document.getElementById('{{ $id }}-subtitle');
            const messageEl = document.getElementById('{{ $id }}-message');
            const targetEl = document.getElementById('{{ $id }}-target');
            const iconWrapperEl = document.getElementById('{{ $id }}-icon-wrapper');
            const iconEl = document.getElementById('{{ $id }}-icon');
            const confirmBtn = modalEl.querySelector('[data-modal-confirm]');
            const cancelBtn = modalEl.querySelector('[data-modal-cancel]');
            const closeBtn = modalEl.querySelector('[data-modal-close]');

            let resolvePromise = null;

            const icons = {
                danger: '⚠️',
                warning: '🔔',
                info: 'ℹ️',
                success: '✓'
            };

            function show(options) {
                options = options || {};
                const type = options.type || 'danger';

                if (titleEl) titleEl.textContent = options.title || '確認';
                if (subtitleEl) {
                    if (options.subtitle) {
                        subtitleEl.textContent = options.subtitle;
                        subtitleEl.style.display = 'block';
                    } else {
                        subtitleEl.style.display = 'none';
                    }
                }

                if (messageEl) {
                    messageEl.textContent = options.message || '本当に削除しますか？';
                }

                if (targetEl) {
                    if (options.targetName) {
                        targetEl.textContent = '対象: ' + options.targetName;
                        targetEl.style.display = 'block';
                    } else {
                        targetEl.style.display = 'none';
                    }
                }

                if (iconWrapperEl) {
                    iconWrapperEl.className = 'common-modal-icon-wrapper ' + type;
                }
                if (iconEl) {
                    iconEl.textContent = icons[type] || '⚠️';
                }

                if (confirmBtn) {
                    confirmBtn.textContent = options.confirmText || 'OK';
                    confirmBtn.className = 'btn-modal btn-modal-confirm ' + type;
                }

                if (cancelBtn) {
                    cancelBtn.textContent = options.cancelText || 'キャンセル';
                    cancelBtn.style.display = options.isAlert ? 'none' : '';
                }

                modalEl.style.display = 'flex';
                modalEl.offsetHeight;
                modalEl.classList.add('is-open');
                modalEl.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';

                if (confirmBtn) confirmBtn.focus();

                return new Promise(function (resolve) {
                    resolvePromise = resolve;
                });
            }

            function hide(result) {
                modalEl.classList.remove('is-open');
                modalEl.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
                setTimeout(function () {
                    if (!modalEl.classList.contains('is-open')) {
                        modalEl.style.display = 'none';
                    }
                }, 200);

                if (resolvePromise) {
                    resolvePromise(result);
                    resolvePromise = null;
                }
            }

            if (confirmBtn) {
                confirmBtn.addEventListener('click', function () {
                    hide(true);
                });
            }

            if (cancelBtn) {
                cancelBtn.addEventListener('click', function () {
                    hide(false);
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    hide(false);
                });
            }

            modalEl.addEventListener('click', function (e) {
                if (e.target === modalEl) {
                    hide(false);
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modalEl.classList.contains('is-open')) {
                    hide(false);
                }
            });

            // =========================================================================
            // Declarative HTML Auto-delegation (Zero JS required on individual pages)
            // =========================================================================
            document.addEventListener('submit', function (e) {
                const form = e.target;
                if (!form || !form.hasAttribute('data-confirm')) return;
                if (form.getAttribute('data-confirmed') === 'true') return;

                e.preventDefault();

                show({
                    title: form.getAttribute('data-confirm-title') || '確認',
                    message: form.getAttribute('data-confirm') || '本当に実行しますか？',
                    subtitle: form.getAttribute('data-confirm-subtitle') || 'この操作は取り消せません。',
                    targetName: form.getAttribute('data-confirm-target') || '',
                    type: form.getAttribute('data-confirm-type') || 'danger',
                    confirmText: form.getAttribute('data-confirm-btn') || 'OK',
                    cancelText: form.getAttribute('data-cancel-btn') || 'キャンセル'
                }).then(function (confirmed) {
                    if (confirmed) {
                        form.setAttribute('data-confirmed', 'true');
                        form.submit();
                    }
                });
            });

            // Declarative click delegation for links or action buttons
            document.addEventListener('click', function (e) {
                const trigger = e.target.closest('[data-confirm]');
                if (!trigger) return;
                // Form submits are handled by submit event
                if (trigger.tagName.toLowerCase() === 'form' || (trigger.tagName.toLowerCase() === 'button' && trigger.type === 'submit' && trigger.form && trigger.form.hasAttribute('data-confirm'))) {
                    return;
                }

                if (trigger.getAttribute('data-confirmed') === 'true') return;

                e.preventDefault();

                show({
                    title: trigger.getAttribute('data-confirm-title') || '確認',
                    message: trigger.getAttribute('data-confirm') || '本当に実行しますか？',
                    subtitle: trigger.getAttribute('data-confirm-subtitle') || '',
                    targetName: trigger.getAttribute('data-confirm-target') || '',
                    type: trigger.getAttribute('data-confirm-type') || 'warning',
                    confirmText: trigger.getAttribute('data-confirm-btn') || 'OK',
                    cancelText: trigger.getAttribute('data-cancel-btn') || 'キャンセル'
                }).then(function (confirmed) {
                    if (confirmed) {
                        trigger.setAttribute('data-confirmed', 'true');
                        if (trigger.tagName.toLowerCase() === 'a' && trigger.href) {
                            window.location.href = trigger.href;
                        } else if (typeof trigger.onclick === 'function') {
                            trigger.onclick();
                        }
                    }
                });
            });

            window.CommonModal = {
                confirm: function (options) {
                    return show(Object.assign({}, options, { isAlert: false }));
                },
                alert: function (options) {
                    return show(Object.assign({}, options, { isAlert: true }));
                },
                open: function (options) {
                    const cb = options.onConfirm;
                    show(options).then(function (confirmed) {
                        if (confirmed && typeof cb === 'function') {
                            cb();
                        }
                    });
                },
                close: function () {
                    hide(false);
                }
            };
        })();
    </script>
@endif
