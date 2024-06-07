<?php

namespace App\Http\Controllers;

use App\Models\antrian;
use App\Models\Banner;
use App\Models\Footer;
use App\Models\KategoriPelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DisplayController extends Controller
{
    public function displayView(){
        $antrian = antrian::where('status_antrian', 'menunggu')
        ->groupBy('id_kategori_layanan')
        ->selectRaw('id_kategori_layanan, MIN(nomor_urut) AS nomor_urut_terendah')
        ->get();
        // Kembalikan view display antrian dengan data antrian teratas per kategori
        return view('pages.display', compact('antrian'));
    }
    
    public function display(){
        $antrian = antrian::where('status_antrian', 'menunggu')
        ->groupBy('id_kategori_layanan')
        ->selectRaw('id_kategori_layanan, MIN(nomor_urut) AS nomor_urut_terendah')
        ->with('kategoriLayanan')
        ->get();

        $dataAntrian = [];
        foreach ($antrian as $antrianItem) {
            $dataAntrian[] = [
                'nomor_urut' => $antrianItem->nomor_urut_terendah,
                'kode_pelayanan' => $antrianItem->kategoriLayanan->kode_pelayanan, 
                'nama_pelayanan' => $antrianItem->kategoriLayanan->nama_pelayanan, 
            ];
        }
    return response()->json($dataAntrian);
    }

    public function form(){
        $kategoriLayanan = KategoriPelayanan::all();
        if (!$kategoriLayanan) {
            return response()->json([
                'message' => 'Data Kategori tidak ditemukan',
            ], 404);
        }
        return response()->json($kategoriLayanan);
    }

    public function getFooter(){
        $footerData = Footer::first();

        if (!$footerData) {
            return response()->json([
                'message' => 'Data footer tidak ditemukan',
            ], 404);
        }

        return response()->json($footerData);
    }

    // public function getImages(){
    //     $images = Storage::files('banner');
    //     $imageUrls = [];

    //     foreach ($images as $image) {
    //         $imageUrl = Storage::url($image);
    //         $imageInfo = pathinfo($image);
    //         $imageName = $imageInfo['filename'];

    //         $imageUrls[] = [
    //             'name' => $imageName,
    //             'url' => $imageUrl,
    //         ];
    //     }

    //     return response()->json($imageUrls);
    // }

    public function getBanner(){
        $banner = Banner::all();
        $bannerName = $banner->pluck('image_banner');
        return response()->json($bannerName);
    }
}
