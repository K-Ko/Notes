/**
 *
 *
 * @author     Knut Kohl <github@knutkohl.de>
 * @copyright  2016 Knut Kohl
 * @license    MIT License (MIT) http://opensource.org/licenses/MIT
 * @version    1.0.0
 */

/**
 *
 */
var API = '/api';

/**
 *
 */
var I18N;

/**
 *
 */
$(document).ready(function() {

    PNotify.prototype.options.styling = 'fontawesome';
    // Downward compatible shortcut
    $.pnotify = function(msg) { return new PNotify(msg) };

    $(document).ajaxSend(function(event, jqxhr, settings) {
    	$('.ajax-loader').show();
        jqxhr.setRequestHeader('Content-Type', 'application/json');
    });

    $(document).ajaxComplete(function( event, xhr, settings ) {
    	$('.ajax-loader').hide();
    });

    $(document).ajaxError(function(event, jqxhr, settings) {
        if (jqxhr.status == 401) {
            Cookies.remove('token');
            location.href = '/';
            return;
        }
        console.log(event, jqxhr, settings);
        $.pnotify({
            type: 'error',
            title: 'Error',
            text: jqxhr.responseJSON ? jqxhr.responseJSON : jqxhr.status + ' ' + jqxhr.statusText
        });
    });

    $.getJSON(
        API + '/config'
    ).done(function(config) {
        I18N = config.i18n;

        initMarkdownEditor(I18N.__language);

        $('*[data-i18n-text]' ).each(function() {
            $(this).html(_($(this).data('i18n-text')));
        });
        $('*[data-i18n-value]').each(function() {
            $(this).val(_($(this).data('i18n-value')));
        });
        $('*[data-i18n-title]').each(function() {
            $(this).prop('title', _($(this).data('i18n-title')));
        });

        $('[data-toggle="tooltip"]').tooltip({ container: 'body' });

        $('*[data-i18n-placeholder]').each(function() {
            $(this).prop('placeholder', _($(this).data('i18n-placeholder')));
        });

        $('#version').text(config.version[0]);
        $('#version-date').text(config.version[1]);

        // Toggle contents after translations was applied
        if (Cookies.get('token')) {
            renderNotesList();
            renderTagCloud();
        } else {
            toggleLogin();
        }

    });

    $('.container').on('click', 'a.show-note', function() {
        renderNote($(this).data('uid'));
    });

    $('.container').on('click', 'a.search-for-tag', function(e) {
        if (!e.isDefaultPrevented()) {
            renderNotesList($(this).data('tag'));
        }
    });

    $('a.notes-home').on('click', function() {
        $('.navbar-nav li'). removeClass('active');
        $(this).closest('li').addClass('active');
        renderNotesList();
        renderTagCloud();
    });

    $('a.notes-add').on('click', function() {
        $('.navbar-nav li'). removeClass('active');
        $(this).closest('li').addClass('active');
        editNote();
    });

    $('input[data-provides="login"]').on('keypress', function(e) {
        if (e.which == 13) { // Enter
            $('button[data-provides="login"]').trigger('click');
        }
    });

    $('button[data-provides="login"]').on('click', function() {
    	var user = $('#login-user'), pass = $('#login-password'), err;

        // Trigger BOTH checks
        err = !checkRequired(user);
        err = !checkRequired(pass) || err;
        if (err) return;

        $.post(
            API + '/login',
            JSON.stringify({ user: user.val(), password: pass.val() })
        ).done(function(data) {
            $.pnotify({
                type: 'success',
                text: _('Welcome') + ' ' + data.user + '!'
            });
            renderNotesList();
            renderTagCloud();
        });
    });

    $('a.notes-logout').on('click', function() {
        $.post(
            API + '/logout',
            JSON.stringify({ token: Cookies.get('token') })
        ).always(function() {
            Cookies.remove('token')
            location.href = '/';
        });
    });

    $('button.edit-note').on('click', function() {
        $.getJSON(
            API + '/notes/'+$(this).data('uid')
        ).done(function(data) {
            editNote(data);
        });
    });

    $('button.edit-cancel').on('click', function() {
        renderNote($(this).data('uid'));
    });

    // Save note on Enter in title
    $('#edit-title').on('keyup', function(e) {
        e.preventDefault();
        if (e.key == 'Enter') {
            $('button.save-note').trigger('click');
        }
    });

    // Save note on Ctrl+Enter in content area
    $('#edit-content').on('keyup', function(e) {
        e.preventDefault();
        if (e.ctrlKey && e.key == 'Enter') {
            $('button.save-note').trigger('click');
        }
    });

    $('button.delete-note').on('click', function() {
        var $this = $(this);
        ($.pnotify({
            title: _('DeleteNote'),
            text: _('AreYouSure'),
            icon: 'fa fa-question-circle',
            hide: false,
            confirm: {
                confirm: true,
                buttons: [ { text: _('Yes') }, { text: _('No') } ]
            },
            buttons: { closer: false, sticker: false },
            history: { history: false },
            addclass: 'stack-modal',
            stack: {'dir1': 'down', 'dir2': 'right', 'modal': true}
        })).get(
        ).on('pnotify.confirm', function(){
            $.ajax({
                url: API + '/notes/' + $this.data('uid'),
                type: 'DELETE',
            }).done(function(data) {
                $.pnotify({ type: 'success', text: _('NoteDeleted') });
                renderNotesList();
                renderTagCloud();
            });
            $('.ui-pnotify-modal-overlay').remove();
        }).on('pnotify.cancel', function(){
            $('.ui-pnotify-modal-overlay').remove();
        });
    });

    $('button.save-note').on('click', function() {
        var t = $('#edit-title'),
            c = $('#edit-content'),
            uid = $(this).data('uid'),
            url = (uid ? '/'+uid : ''),
            data = { uid: uid, title: t.val(), content: c.val() },
            err;

        // Trigger BOTH checks
        err = !checkRequired(t);
        err = !checkRequired(c) || err;
        if (err) return;

        $.ajax({
            url: API + '/notes' + url,
            type: uid ? 'POST' : 'PUT',
            data: JSON.stringify(data)
        }).done(function(uid) {
            $.pnotify({ type: 'success', text: _('NoteSaved') });
            renderNote(uid);
            renderTagCloud();
        });
    });

    $('input[data-provides="search"]').on('keypress', function(e) {
        if (e.which == 13) { // Enter
            $('button[data-provides="search"]').trigger('click');
        }
    });

    $('button[data-provides="search"]').on('click', function(e) {

        var q = $('input[data-provides="search"]');

        if (!q.val()) return;

        toggleContent();

        $.getJSON(
            API + '/notes',
            { q: q.val() }
        ).done(function(notes) {
            var h1 = $('h1', '.content.notes-list');
            h1.text(_(h1.data('i18n-text')));

            if (notes.length) {
                var el = $('<ul/>').addClass('list');

                $.each(notes, function(id, note) {
                    el.append(renderNoteListItem(note));
                });

                $('ul.nav.navbar-nav li').removeClass('active');
                $('li[data-item="home"]', 'ul.nav.navbar-nav').addClass('active');

            } else {
                var el = $('<p/>').html(_('NothingFound'));
            }

            $('div', '.content.list').empty().html(el);
        }).always(function(){
            toggleContent('list');
        });

        q.blur().val('');
    });

});

/**
 *
 */
function initMarkdownEditor(language) {
    $('textarea.markdown').markdown({
        autofocus: false,
        iconlibrary: 'fa',
        language: language,
    });

    // Switch Preview button class
    $('button[data-handler=bootstrap-markdown-cmdPreview]').removeClass('btn-primary').addClass('btn-default');

    // Append link
    $('.md-header.btn-toolbar').append(
       '<div class="btn-group md-help pull-right">'+
       '    <a class="btn btn-sm" type="button"'+
       '       href="https://daringfireball.net/projects/markdown/syntax"'+
       '       target="_blank"><i class="fa fa-fw fa-external-link-square"></i> <span data-i18n-text="MarkDownSyntaxHelp"></span></a>'+
       '</div>');
}

/**
 *
 */
function renderNotesList(tag) {

    toggleContent();

    var data = tag ? { t: tag } : null;

    $.getJSON(
        API + '/notes',
        data
    ).done(function(notes) {
        var h1 = $('h1', '.content.notes-list');
        var el = $('<ul/>').addClass('list');

        h1.text(tag ? '#'+tag : _(h1.data('i18n-text')));

        $.each(notes, function(id, note) {
            el.append(renderNoteListItem(note));
        });

        $('ul.nav.navbar-nav li').removeClass('active');
        $('li[data-item="home"]', 'ul.nav.navbar-nav').addClass('active');

        $('div', '.content.list').empty().html(el);
    }).always(function(){
        toggleContent('list');
    });

}

/**
 *
 */
function renderNoteListItem(note) {
    var el = $('<li/>').append(
        $('<a/>').addClass('show-note').data('uid', note.uid).prop('href', '#').text(note.title)
    );

    if (note.tags.length) {
        el.append('&nbsp; |');
        $.each(note.tags, function(id, tag) {
            el.append(' &nbsp; ').append(
                $('<a/>').addClass('search-for-tag').data('tag', tag).prop('href', '#').text('#'+tag)
            );
        });
    }

    return el;
}

/**
 *
 */
function renderNote(uid) {
    $.getJSON(
        API + '/notes/'+uid
    ).done(function(note) {
        note.content = marked(
            note.content,
            { sanitize: true, smartypants: true }
        );

        var r;

        for (var i in note.tags) {
            r = new RegExp('#('+note.tags[i]+')([^\w])');
            note.content = note.content.replace(r, '<a class="search-for-tag" href="#" data-tag="$1">#$1</a>$2');
        }

        showNote(note);
    });
}

/**
 *
 */
function showNote(note) {
    toggleContent();

    $('.edit-note').data('uid', note.uid);
    $('.edit-cancel').data('uid', note.uid);
    $('.delete-note').data('uid', note.uid);

    $('#show-title').html(note.title);
    $('#show-content').html(note.content);

    $('.notes-created').text(new Date(note.created).toLocaleString());
    if (note.created != note.changed) {
        $('.notes-changed').text(new Date(note.changed).toLocaleString());
        $('.notes-changed-wrapper').show();
    } else {
        $('.notes-changed-wrapper').hide();
    }

    toggleContent('display');
}

/**
 *
 */
function renderTagCloud(tags) {
    $.getJSON(
        API + '/tags'
    ).done(function(tags) {
        var t = $('div', '#tags').empty();
        $.each(tags, function(id, tag) {
            $('<div/>').addClass('cloud')
            .append(
                $('<a/>').addClass('search-for-tag').data('tag', tag.tag)
                .prop('href', '#').text(tag.tag)
            ).append($('<span/>').addClass('badge').text(tag.count)
            ).appendTo(t);
        });
    });
}

/**
 *
 */
function editNote(note) {
    toggleContent();

    if (note) {
        $('#edit-header').text(_('EditNote'));
        $('#edit-title').val(note.title);
        $('#edit-content').val(note.content);
        $('button.save-note').data('uid', note.uid);
    } else {
        $('#edit-header').text(_('AddNote'));
        $('#edit-title, #edit-content').val('');
        $('button.save-note').data('uid', null);
    }
    // Remove old error markers
    $('#tab-edit div').removeClass('has-error');

    toggleContent('edit');
}

/**
 *
 */
function checkRequired(el) {
    if (!el.val()) {
        el.closest('div').addClass('has-error');
        return false;
    }
    el.closest('div').removeClass('has-error');
    return true;
}

/**
 *
 */
function toggleLogin() {
    $('.row.login').addClass('active');
    $('.row.note').removeClass('active');
    $('body').show();
}

/**
 *
 */
function toggleContent(content) {
    if (!content) {
        $('.row.login').removeClass('active');
        $('.content', '.row.note').removeClass('active');
    } else {
        $('.row.note').addClass('active');
        content && $('.content.'+content, '.row.note').addClass('active');
        if (content == 'edit') {
            $('#column-left').removeClass('col-sm-9').addClass('col-sm-12');
            $('#column-right').removeClass('active');
        } else {
            $('#column-left').removeClass('col-sm-12').addClass('col-sm-9');
            $('#column-right').addClass('active');
        }
        $('body').show();
    }
    $('.tooltip').remove();
}

/**
 *
 */
function _(text) {
    return I18N[text] != undefined ? I18N[text] : '{{' + text + '}}';
}
