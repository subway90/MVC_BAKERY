<!-- sa-app__body -->
<div id="top" class="sa-app__body px-2 px-lg-4">
    <div class="container pb-6">
        <div class="pb-3">
            <div class="row g-4 align-items-center">
                <div class="col">
                    <h1 class="h5 m-0">Thống kê</h1>
                </div>
            </div>
        </div>
        <div class="row g-4 g-xl-5">
            <div class="col-12 col-md-4 d-flex">
                <div class="card saw-indicator flex-grow-1"
                    data-sa-container-query="{&quot;340&quot;:&quot;saw-indicator--size--lg&quot;}">
                    <div class="sa-widget-header saw-indicator__header">
                        <h2 class="sa-widget-header__title">Doanh thu hôm nay</h2>
                        <div class="sa-widget-header__actions">
                        </div>
                    </div>
                    <div class="saw-indicator__body">
                        <div class="saw-indicator__value"><?= number_format(revenue('today'), 0, 0, '.') ?> <span
                                class="small fs-5 fw-light">vnđ</span></div>
                        <?= render_compare_revenue('today') ?>
                        <div class="saw-indicator__caption">So với hôm qua</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 d-flex">
                <div class="card saw-indicator flex-grow-1"
                    data-sa-container-query="{&quot;340&quot;:&quot;saw-indicator--size--lg&quot;}">
                    <div class="sa-widget-header saw-indicator__header">
                        <h2 class="sa-widget-header__title">Doanh thu tuần này</h2>
                        <div class="sa-widget-header__actions">
                        </div>
                    </div>
                    <div class="saw-indicator__body">
                        <div class="saw-indicator__value"><?= number_format(revenue('this week'), 0, 0, '.') ?> <span
                                class="small fs-5 fw-light">vnđ</span></div>
                        <?= render_compare_revenue('week') ?>
                        <div class="saw-indicator__caption">So với tuần trước</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 d-flex">
                <div class="card saw-indicator flex-grow-1"
                    data-sa-container-query="{&quot;340&quot;:&quot;saw-indicator--size--lg&quot;}">
                    <div class="sa-widget-header saw-indicator__header">
                        <h2 class="sa-widget-header__title">Doanh thu tháng này</h2>
                        <div class="sa-widget-header__actions">
                        </div>
                    </div>
                    <div class="saw-indicator__body">
                        <div class="saw-indicator__value"><?= number_format(revenue('this month'), 0, 0, '.') ?> <span
                                class="small fs-5 fw-light">vnđ</span></div>
                        <?= render_compare_revenue('month') ?>
                        <div class="saw-indicator__caption">So với tháng trước</div>
                    </div>
                </div>
            </div>
            <div class="row mt-4 align-items-center">
                <div class="col">
                    <h1 class="h5 m-0">Biểu đồ thống kê</h1>
                </div>
            </div>
            <!-- <div class="col-12 col-lg-4 col-xxl-3 d-flex">
                <div class="card flex-grow-1 saw-pulse"
                    data-sa-container-query="{&quot;560&quot;:&quot;saw-pulse--size--lg&quot;}">
                    <div class="sa-widget-header saw-pulse__header">
                        <h2 class="sa-widget-header__title">Tổng bán tháng này</h2>
                        <div class="sa-widget-header__actions">
                        </div>
                    </div>
                    <div class="saw-pulse__counter">44</div>
                    <div class="sa-widget-table saw-pulse__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-end">Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì gà</a>
                                    </td>
                                    <td class="text-end">15</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì thịt heo</a>
                                    </td>
                                    <td class="text-end">11</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì ốp la</a>
                                    </td>
                                    <td class="text-end">7</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì thập cẩm</a>
                                    </td>
                                    <td class="text-end">4</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì chảo</a>
                                    </td>
                                    <td class="text-end">3</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì ngọt</a>
                                    </td>
                                    <td class="text-end">3</td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="text-reset">Bánh mì lạp xưởng</a>
                                    </td>
                                    <td class="text-end">1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->
            <div class="col-12 d-flex">
                <div class="card flex-grow-1 saw-chart" data-sa-data="[
                        <?php
                        $count = count($data_chart);
                        foreach ($data_chart as $i => $row) :
                            // format label theo type
                            if($type_chart === 'ngay') $row['date'] = convert_weekday($row['order_of_week']) . format_time($row['date'].' 00:00:00',' DD/MM');
                            if($type_chart === 'tuan') $row['date'] = 'Tuần '.$row['date'].format_time($row['start'],' : DD/MM').format_time($row['end'],' → DD/MM');
                            if($type_chart === 'thang') $row['date'] = 'Tháng '.$row['date'].format_time($row['start'],' : DD/MM').format_time($row['end'],' → DD/MM');
                            if($type_chart === 'nam') $row['date'] = 'Năm '.$row['date'].format_time($row['start'],' : DD/MM').format_time($row['end'],' → DD/MM');
                            $last_string = '';
                            if ($i + 1 < $count)
                                $last_string = ',';
                            echo <<<HTML
                                {&quot;label&quot;:&quot;{$row['date']}&quot;,&quot;value&quot;:{$row['total']} } {$last_string}
                                HTML;
                        endforeach;
                        ?>
                        ]">
                    <form method="post">
                    <div class="sa-widget-header saw-chart__header">
                        <div class="w-100 d-flex flex-column flex-md-row justify-content-between gap-3">
                            <div class="sa-chart-toolbar__body align-items-center">
                                <div class="sa-chart-toolbar__item me-auto">
                                    <label for="analytics/date-range" class="sa-chart-toolbar__item-label">Khoảng thời gian</label>
                                    <input style="width:200px" name="duration_time" value="<?= $duration_time ?>" type="text" 
                                        class="form-control form-control-sm datepicker-here" 
                                        data-range="true"
                                        data-multiple-dates-separator=" đến "
                                        data-toggle-selected="false" 
                                        placeholder="Nhấn vào để chọn" 
                                        data-auto-close="true" 
                                        data-language="en"
                                        data-date-format="dd-mm-yyyy"
                                        data-first-day="1" 
                                        aria-label="Datepicker" />
                                </div>
                            </div>
                            <div class="sa-chart-toolbar__body justify-content-between">
                                <div class="sa-chart-toolbar__item">
                                    <label for="analytics/group-by" class="sa-chart-toolbar__item-label">Nhóm theo</label>
                                    <select name="type_chart" id="analytics/group-by" class="form-select form-select-sm">
                                        <option <?= $type_chart === 'ngay' ? 'selected' : '' ?> value="ngay">Ngày</option>
                                        <option <?= $type_chart === 'tuan' ? 'selected' : '' ?> value="tuan">Tuần</option>
                                        <option <?= $type_chart === 'thang' ? 'selected' : '' ?> value="thang">Tháng</option>
                                        <option <?= $type_chart === 'nam' ? 'selected' : '' ?> value="nam">Năm</option>
                                    </select>
                                    <button name="filter_chart" type="submit" class="btn btn-sm btn-primary ms-4 px-4">
                                        Lọc
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <div class="saw-chart__body">
                        <div class="saw-chart__container">
                            <canvas></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- sa-app__body / end -->