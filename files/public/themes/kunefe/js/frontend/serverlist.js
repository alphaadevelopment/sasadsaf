// Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com>
//
// Permission is hereby granted, free of charge, to any person obtaining a copy
// of this software and associated documentation files (the "Software"), to deal
// in the Software without restriction, including without limitation the rights
// to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
// copies of the Software, and to permit persons to whom the Software is
// furnished to do so, subject to the following conditions:
//
// The above copyright notice and this permission notice shall be included in all
// copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
// OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
// SOFTWARE.
(function updateServerStatus() {
    var Status = {
        0: 'Offline',
        1: 'Online',
        2: 'Starting',
        3: 'Stopping'
    };
    $('.sunucu-guncelleme').each(function (index, data) {
        var element = $(this);
        var serverShortUUID = $(this).data('server');

        $.ajax({
            type: 'GET',
            url: Router.route('index.status', { server: serverShortUUID }),
            timeout: 5000,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
            }
        }).done(function (data) {
            if (typeof data.status === 'undefined') {
                element.find('[data-action="status"]').html('<span class="badge badge-danger">Error</span>');
                element.find('[data-action="detay_durum"]').html('Error');
                return;
            }
            switch (data.status) {
                case 0:
                    element.find('[data-action="status"]').html('<span class="badge badge-danger">Offline</span>');
                    element.find('[data-action="detay_durum"]').html('Offline');
                    break;
                case 1:
                    element.find('[data-action="status"]').html('<span class="badge badge-success">Online</span>');
                    element.find('[data-action="detay_durum"]').html('Online');
                    break;
                case 2:
                    element.find('[data-action="status"]').html('<span class="badge badge-info">Starting</span>');
                    element.find('[data-action="detay_durum"]').html('Starting');
                    break;
                case 3:
                    element.find('[data-action="status"]').html('<span class="badge badge-info">Stopping</span>');
                    element.find('[data-action="detay_durum"]').html('Stopping');
                    break;
                case 20:
                    element.find('[data-action="status"]').html('<span class="badge badge-warning">Installing</span>');
                    element.find('[data-action="detay_durum"]').html('Installing');
                    break;
                case 30:
                    element.find('[data-action="status"]').html('<span class="badge badge-warning">Suspended</span>');
                    element.find('[data-action="detay_durum"]').html('Suspended');
                    break;
            }
            if (data.status > 0 && data.status < 4) {
                var cpuMax = element.find('[data-action="cpu"]').data('cpumax');
                var currentCpu = data.proc.cpu.total;
                if (cpuMax !== 0) {
                    currentCpu = parseFloat(((data.proc.cpu.total / cpuMax) * 100).toFixed(2).toString());
                }
                if (data.status !== 0) {
                    var cpuMax = element.find('[data-action="cpu"]').data('cpumax');
                    var currentCpu = data.proc.cpu.total;
                    if (cpuMax !== 0) {
                        currentCpu = parseFloat(((data.proc.cpu.total / cpuMax) * 100).toFixed(2).toString());
                    }
                    element.find('[data-action="memory"]').html(parseInt(data.proc.memory.total / (1024 * 1024)));
                    element.find('[data-action="cpu"]').html(Math.round(currentCpu));
                    element.find('[data-action="disk"]').html(parseInt(data.proc.disk.used));

                    element.find('[data-action="detay_ram"]').html(parseInt(data.proc.memory.total / (1024 * 1024)) + ' / ');
                    element.find('[data-action="detay_cpu"]').html(currentCpu + ' / ');
                    element.find('[data-action="detay_disk"]').html(parseInt(data.proc.disk.used) + ' / ');
                } else {
                    element.find('[data-action="memory"]').html('--');
                    element.find('[data-action="cpu"]').html('--');
                    element.find('[data-action="disk"]').html('--');
                }
            }
        }).fail(function (jqXHR) {
            if (jqXHR.status === 504) {
                element.find('[data-action="status"]').html('<span class="badge badge-default">Gateway Timeout</span>');
                element.find('[data-action="detay_durum"]').html('Gateway Timeout');
            } else {
                element.find('[data-action="status"]').html('<span class="badge badge-danger">Error</span>');
                element.find('[data-action="detay_durum"]').html('Error');
            }
        });
    }).promise().done(function () {
        setTimeout(updateServerStatus, 10000);
    });
})();
