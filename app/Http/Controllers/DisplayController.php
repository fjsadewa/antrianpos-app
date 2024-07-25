<?php

namespace App\Http\Controllers;

use App\Models\antrian;
use App\Models\Banner;
use App\Models\Cabang;
use App\Models\DisplaySet;
use App\Models\Footer;
use App\Models\KategoriPelayanan;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class DisplayController extends Controller
{
    public function displayView(){
        $antrian = antrian::where('status_antrian', 'menunggu')
        ->whereDate('tanggal', now())
        ->groupBy('id_kategori_layanan')
        ->selectRaw('id_kategori_layanan, MIN(nomor_urut) AS nomor_urut_terendah')
        ->get();
        return view('pages.display', compact('antrian'));
    }
    
    public function display(){
        $antrian = antrian::where('status_antrian', 'menunggu')
        ->whereDate('tanggal', now())
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

    public function getHeader(){
        $cabangData = Cabang::first();

        if (!$cabangData) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json($cabangData);
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

    public function getVideo() {
        $status = DisplaySet::first();
        if (!$status) {
            return response()->json(['error' => 'No DisplaySet record found'], 404);
        }
        $videoType = $status->status; 

        $video = Video::where('tipe', $videoType)->get();
        if ($video->count() === 0) {
            return response()->json(['error' => 'No video found for type: ' . $videoType], 404);
        }
        $videoData = $video->map(function ($videoItem) {
            return [
                'judul' => $videoItem->judul,
                'link_sumber' => $videoItem->link_sumber,
            ];
        })->toArray();
        
        $response = json_encode([
            'status' => $videoType,
            'data' => $videoData,
        ]);
        return response()->json($response);
    }
}

// if ($videoType === 'youtube') {
        //     $video = Video::where('tipe', 'youtube')->get();
        // } else {
        //     $video = Video::where('tipe', 'local')->get();
        // } 
        
        // $videoData = []; 
        // foreach ($video as $videoItem) {
        //     $videoData[] = [
        //         'judul' => $videoItem->judul,
        //         'link_sumber' => $videoItem->link_sumber,
        //     ];
        // }
        // $response = array_merge(['status' => $videoType], ['data' => $videoData]);