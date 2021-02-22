<div>
    <ul class="uk-breadcrumb">
        <li class="uk-active"><span>@lang('EmailOnUserSave Settings')</span></li>
    </ul>
</div>

@if (empty($collections))
<div class="uk-text-large uk-text-center uk-margin-large-top uk-text-muted">
    <p>@lang('No collections found')</p>
</div>
@endif

<div class="uk-margin-top uk-invisible" if="{collections}" riot-view>

    <form id="account-form" class="uk-form" onsubmit="{ submit }">
        <div class="uk-section uk-section-primary">
            <div class="uk-container uk-container-small"><h1>User Email Settings</h3></div>
        </div>
        <div class="uk-section uk-section-primary uk-margin-top">
            <div class="uk-container uk-container-small">
                <div class="uk-grid uk-grid-divider">
                    <div class="uk-width-1-2">
                        <h3 class="uk-margin-bottom">On Create new user</h3>
                        <div class="uk-form-switch">
                            <input ref="check" type="checkbox" id="onCreateActive" checked="{ settings.sendOnCreate }" bind="settings.sendOnCreate" />
                            <label for="onCreateActive">Active</label>
                        </div>
                        <div class="uk-grid-margin uk-margin-top">

                            <div class="uk-form-row">
                                <label class="uk-text-small">@lang('To')</label>
                                <input class="uk-width-1-1 uk-form-large" type="text" bind="settings.emailCreate.to" autocomplete="off" required>
                            </div>

                            <div class="uk-form-row">
                                <div class="uk-alert">@lang('Use token [:user_mail] in the field to replace with user mail. You can insert more emails separing with comma.')</div>
                            </div>

                            <div class="uk-form-row">
                                <label class="uk-text-small">@lang('Subject')</label>
                                <input class="uk-width-1-1 uk-form-large" type="text" bind="settings.emailCreate.subject" autocomplete="off" required>
                            </div>

                            <div class="uk-form-row">
                                <label class="uk-text-small">@lang('Body')</label>
                                <textarea class="uk-width-1-1 uk-form-large" name="Body" bind="settings.emailCreate.body" rows="14"></textarea>
                                <div class="uk-alert">@lang('Use token [:data] in the body to replace with collection values.')</div>
                            </div>

                        </div>

                    </div>
                    <div class="uk-width-1-2">
                        <h3 class="uk-margin-bottom">On Active new user</h3>
                        <div class="uk-form-switch">
                            <input ref="check" type="checkbox" id="onActivationActive" checked="{ settings.sendOnActive }" bind="settings.sendOnActive" />
                            <label for="onActivationActive">Active</label>
                        </div>
                        <div class="uk-grid-margin uk-margin-top">

                            <div class="uk-form-row">
                                <label class="uk-text-small">@lang('To')</label>
                                <input class="uk-width-1-1 uk-form-large" type="text" bind="settings.emailActive.to" autocomplete="off" required>
                            </div>

                            <div class="uk-form-row">
                                <div class="uk-alert">@lang('Use token [:user_mail] in the field to replace with user mail. You can insert more emails separing with comma.')</div>
                            </div>

                            <div class="uk-form-row">
                                <label class="uk-text-small">@lang('Subject')</label>
                                <input class="uk-width-1-1 uk-form-large" type="text" bind="settings.emailActive.subject" autocomplete="off" required>
                            </div>

                            <div class="uk-form-row">
                                <label class="uk-text-small">@lang('Body')</label>
                                <textarea class="uk-width-1-1 uk-form-large" name="Body" bind="settings.emailActive.body" rows="14"></textarea>
                                <div class="uk-alert">@lang('Use token [:data] in the body to replace with collection values.')</div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--
        <div class="uk-width-small-1-4">
            <h3>Collections</h3>
            <div ref="container" class="uk-form-row" each="{collection, index in collections}" onclick="{ setCollection }" style="cursor:pointer;">
                <div class="uk-form-switch">
                    <input ref="check" type="checkbox" id="{ collection['name'] }" checked="{ settings.collections.includes(collection['name']) }"/>
                    <label for="{ collection['name'] }"></label>
                </div>
                <span>{ collection['label'] }</span>
            </div>
        </div>
        -->

        <div class="uk-section uk-section-primary uk-margin-top">
            <div class="uk-container uk-container-small">
                <center>
                    <button class="uk-button uk-button-large uk-width-1-3 uk-button-primary uk-margin-right">@lang('Save')</button>
                    <a href="@route('/settings')">@lang('Cancel')</a>
                </center>
            </div>
        </div>

    </form>


    <script type="view/script">

        var $this = this, $root = App.$(this.root);

        this.mixin(RiotBindMixin);

        this.collections   = {{ json_encode($collections) }};
        this.settings = {{ json_encode($settings) }};

        this.on('mount', function(){

            this.root.classList.remove('uk-invisible');

            // bind clobal command + save
            Mousetrap.bindGlobal(['command+s', 'ctrl+s'], function(e) {

                e.preventDefault();
                $this.submit();
                return false;
            });


            $this.update();
        });

        submit(e) {
            if(e) e.preventDefault();
            const settings = {
                "sendOnCreate": this.settings.sendOnCreate,
                "sendOnActive": this.settings.sendOnActive,
                "emailCreate": Object.assign({}, this.settings.emailCreate),
                "emailActive": Object.assign({}, this.settings.emailActive),
            }
            console.log(settings);

            App.request("/settings/emailonusersave/save", {"settings": settings}).then(function(data) {
                console.log(data);
                App.ui.notify("Email on Save settings saved", "success");
            });

            return false;

        }

    </script>

</div>


