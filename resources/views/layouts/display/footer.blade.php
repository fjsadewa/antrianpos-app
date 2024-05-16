<div class="footer" style=" background-color: #EE3F22!important; color: #fff!important;">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-2 pl-0 pr-1 datetime-content-footer text-center">
                <div id="datetime"
                    style="font: bold; font-size: 20px; padding: 3px; color: #000;
                    background: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.50);
                    border radius: 4px; border-right: 2px #1B2C5A solid">
                </div>
            </div>
            <div class="col-md-10 marquee-content-footer">
                <marquee scrollamount="10" style="white-space:nowrap; overflow:hidden">
                    @foreach ($footer as $footerItem)
                        <h4 class="font-weight-bold">{{ $footerItem->text }}</h4>
                    @endforeach
                    {{-- <h4 class="font-weight-bold">
                        {{ $footer->text }}
                        Kantor POS Indonesia Cabang Utama Malang
                        | Cargo & Freight Company
                        | 🕗 24 Jam
                        | Customer Service (WA Only) 0856 4801 8702 & 085791673245
                        | Gratis Pick Up/Jemput Paket Hub. 081133365100
                        | FB: posindonesiamalang | Instagram: posaja_malang
                        | Copyright © 2024 POS INDONESIA. All rights reserved.
                    </h4> --}}
                </marquee>
            </div>
        </div>
    </div>
</div>
