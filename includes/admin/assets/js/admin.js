jQuery(document).ready(function($) {
    $('.jh-pro-feature').each(function() {
        // Pricing page URL
        var pricingUrl = 'admin.php?page=disabled-source-disabled-right-click-and-content-protection-pricing';
        
        // Create the button
        var $btn = $('<a href="' + pricingUrl + '" class="jh-pro-buy-btn">Upgrade to Pro</a>');
        
        // Append to the section
        $(this).append($btn);
    });

    /* ─────────────────────────────────────────────────────────────
     * Magic Login / Temp Login Handlers
     * ─────────────────────────────────────────────────────────── */

    function copyToClipboard(text, $btn) {
        if (!text) return;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(function() {
                showCopied($btn);
            }).catch(function() {
                fallbackCopy(text, $btn);
            });
        } else {
            fallbackCopy(text, $btn);
        }
    }

    function fallbackCopy(text, $btn) {
        var $temp = $('<input>');
        $('body').append($temp);
        $temp.val(text).select();
        document.execCommand('copy');
        $temp.remove();
        showCopied($btn);
    }

    function showCopied($btn) {
        var $text = $btn.find('.jh-copy-text');
        var origText = $text.text();
        $btn.addClass('jh-copied');
        $text.text('Copied!');
        setTimeout(function() {
            $btn.removeClass('jh-copied');
            $text.text(origText);
        }, 2000);
    }

    // Generate Magic Link Button Click (AJAX Save)
    $(document).on('click', '#jh-magic-generate-btn', function(e) {
        e.preventDefault();

        var $btn       = $(this);
        var $container = $('#jh-magic-login-form');
        var userId     = $('#jh-ml-user').val();
        var nonce      = $('#jh_magic_login_nonce').val() || $container.find('[name="_nonce"]').val();

        if (!userId) {
            alert('Please select a valid user.');
            $('#jh-ml-user').focus();
            return;
        }

        $btn.prop('disabled', true);
        $btn.find('.jh-btn-text').hide();
        $btn.find('.jh-btn-icon').hide();
        $btn.find('.jh-btn-spinner').show();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action:      'jh_create_magic_link',
                _nonce:      nonce,
                user_id:     userId,
                duration:    $('#jh-ml-duration').val(),
                max_uses:    $('#jh-ml-max-uses').val(),
                label:       $('#jh-ml-label').val(),
                redirect_to: $('#jh-ml-redirect').val()
            },
            success: function(res) {
                $btn.prop('disabled', false);
                $btn.find('.jh-btn-spinner').hide();
                $btn.find('.jh-btn-text').show();
                $btn.find('.jh-btn-icon').show();

                if (!res.success) {
                    alert(res.data && res.data.message ? res.data.message : 'Failed to generate link.');
                    return;
                }

                var d = res.data;

                // Show result box
                $('#jh-magic-result-url').val(d.login_url);
                $('#jh-magic-result-meta').html(
                    '<strong>' + d.display_name + '</strong> (' + d.user_role + ') &nbsp;|&nbsp; ' +
                    '⏱ Expires: ' + d.expires_label + ' (' + d.duration_label + ') &nbsp;|&nbsp; ' +
                    'Max uses: ' + (d.max_uses > 0 ? d.max_uses : 'Unlimited')
                );
                $('#jh-magic-result-card').slideDown(300);

                // Append or create row in table
                var $tbody = $('#jh-magic-tbody');
                var usesLabel = (d.max_uses > 0) ? ('0 / ' + d.max_uses) : '0 / ∞';
                var labelHtml = d.label ? ('<span class="jh-ml-label-text">"' + $('<div>').text(d.label).html() + '"</span>') : '';

                var rowHtml = '<tr id="jh-ml-row-' + d.token + '" data-token="' + d.token + '">' +
                    '<td class="jh-ml-num">' + ($tbody.length ? ($tbody.find('tr').length + 1) : 1) + '</td>' +
                    '<td>' +
                        '<strong class="jh-ml-user-name">' + $('<div>').text(d.display_name).html() + '</strong>' +
                        '<div class="jh-ml-user-meta">' +
                            '<span class="jh-ml-role-chip">' + $('<div>').text(d.user_role).html() + '</span>' +
                            labelHtml +
                        '</div>' +
                    '</td>' +
                    '<td><span class="jh-ml-date">' + d.expires_label + '</span></td>' +
                    '<td><span class="jh-ml-usage">' + usesLabel + '</span></td>' +
                    '<td>' +
                        '<button type="button" class="jh-magic-btn jh-magic-btn-sm jh-magic-row-copy-btn" data-url="' + d.login_url + '">' +
                            '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> ' +
                            '<span class="jh-copy-text">Copy Link</span>' +
                        '</button>' +
                    '</td>' +
                    '<td>' +
                        '<button type="button" class="jh-magic-btn jh-magic-btn-sm jh-magic-btn-danger jh-magic-revoke-btn" data-token="' + d.token + '">' +
                            '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> ' +
                            '<span>Revoke</span>' +
                        '</button>' +
                    '</td>' +
                '</tr>';

                if ($tbody.length) {
                    $tbody.append(rowHtml);
                } else {
                    $('#jh-magic-table-wrap').html(
                        '<table class="jh-magic-table" id="jh-magic-table">' +
                        '<thead><tr>' +
                        '<th>#</th><th>User / Label</th><th>Expires In</th>' +
                        '<th>Usage</th><th>Magic Link</th><th>Actions</th>' +
                        '</tr></thead>' +
                        '<tbody id="jh-magic-tbody">' + rowHtml + '</tbody>' +
                        '</table>'
                    );
                }

                // Update count badge
                var count = parseInt($('#jh-magic-count-badge').text(), 10) || 0;
                $('#jh-magic-count-badge').text(count + 1);

                // Clear label field
                $container.find('[name="label"]').val('');
            },
            error: function() {
                $btn.prop('disabled', false);
                $btn.find('.jh-btn-spinner').hide();
                $btn.find('.jh-btn-text').show();
                $btn.find('.jh-btn-icon').show();
                alert('An error occurred. Please try again.');
            }
        });
    });

    // Copy link from result box
    $(document).on('click', '#jh-magic-copy-main-btn', function() {
        var url = $('#jh-magic-result-url').val();
        copyToClipboard(url, $(this));
    });

    // Copy link from table row
    $(document).on('click', '.jh-magic-row-copy-btn', function() {
        var url = $(this).data('url');
        copyToClipboard(url, $(this));
    });

    // Revoke link
    $(document).on('click', '.jh-magic-revoke-btn', function() {
        if (!confirm('Are you sure you want to revoke this magic login link? It will immediately stop working.')) {
            return;
        }

        var $btn  = $(this);
        var token = $btn.data('token');
        var $row  = $('#jh-ml-row-' + token);
        var nonce = $('#jh_magic_login_nonce').val();

        $btn.prop('disabled', true);

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'jh_delete_magic_link',
                _nonce: nonce,
                token:  token
            },
            success: function(res) {
                if (res.success) {
                    $row.fadeOut(300, function() {
                        $row.remove();
                        var count = parseInt($('#jh-magic-count-badge').text(), 10) || 1;
                        $('#jh-magic-count-badge').text(Math.max(0, count - 1));

                        if ($('#jh-magic-tbody tr').length === 0) {
                            $('#jh-magic-table-wrap').html(
                                '<div id="jh-magic-empty-state" class="jh-magic-empty-state">' +
                                '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><path d="m4.93 4.93 14.14 14.14"></path></svg>' +
                                '<p>No active temporary login links.</p>' +
                                '<span>Use the form above to generate a passwordless magic login link.</span>' +
                                '</div>'
                            );
                        }
                    });
                } else {
                    $btn.prop('disabled', false);
                    alert(res.data && res.data.message ? res.data.message : 'Failed to revoke link.');
                }
            },
            error: function() {
                $btn.prop('disabled', false);
                alert('An error occurred while revoking the link.');
            }
        });
    });
});

