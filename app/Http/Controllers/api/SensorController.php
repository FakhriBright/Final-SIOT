<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SensorController extends Controller
{
    // GET ALL SENSOR
    public function index()
    {
        try {

            $sensors = Sensor::all();

            return response()->json([
                'status' => 'success',
                'code' => Response::HTTP_OK,
                'message' => 'Berhasil mengambil data sensor',
                'data' => $sensors
            ], Response::HTTP_OK);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'fail',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // GET SENSOR BY ID
    public function show($id)
    {
        try {

            $sensor = Sensor::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'code' => Response::HTTP_OK,
                'message' => "Berhasil mengambil data sensor ID $id",
                'data' => $sensor
            ], Response::HTTP_OK);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status' => 'fail',
                'code' => Response::HTTP_NOT_FOUND,
                'message' => "Sensor dengan ID $id tidak ditemukan",
                'data' => null
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'fail',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // STORE SENSOR
    public function store(Request $request)
    {
        try {

            $validatedData = Validator::make($request->all(), [
                'nama_sensor' => 'required|min:2',
                'lokasi' => 'required',
                'nilai' => 'required'
            ], [
                'nama_sensor.required' => 'Nama sensor wajib diisi',
                'nama_sensor.min' => 'Nama sensor minimal 2 karakter',
                'lokasi.required' => 'Lokasi wajib diisi',
                'nilai.required' => 'Nilai sensor wajib diisi'
            ]);

            if (!$validatedData->fails()) {

                $sensor = Sensor::create([
                    'nama_sensor' => $request->nama_sensor,
                    'lokasi' => $request->lokasi,
                    'nilai' => $request->nilai,
                    'status' => true,
                ]);

                return response()->json([
                    'status' => 'success',
                    'code' => Response::HTTP_CREATED,
                    'message' => 'Berhasil menambahkan sensor',
                    'data' => $sensor
                ], Response::HTTP_CREATED);

            } else {

                throw new ValidationException($validatedData);
            }

        } catch (ValidationException $e) {

            return response()->json([
                'status' => 'fail',
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $e->errors(),
                'data' => null
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'fail',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // UPDATE SENSOR
    public function update(Request $request, $id)
    {
        try {

            $validatedData = Validator::make($request->all(), [
                'nama_sensor' => 'required|min:2',
                'lokasi' => 'required',
                'nilai' => 'required'
            ]);

            if (!$validatedData->fails()) {

                $sensor = Sensor::findOrFail($id);

                $sensor->update([
                    'nama_sensor' => $request->nama_sensor,
                    'lokasi' => $request->lokasi,
                    'nilai' => $request->nilai,
                    'status' => $request->status ?? true,
                ]);

                return response()->json([
                    'status' => 'success',
                    'code' => Response::HTTP_OK,
                    'message' => "Berhasil update sensor ID $id",
                    'data' => $sensor
                ], Response::HTTP_OK);

            } else {

                throw new ValidationException($validatedData);
            }

        } catch (ValidationException $e) {

            return response()->json([
                'status' => 'fail',
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $e->errors(),
                'data' => null
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status' => 'fail',
                'code' => Response::HTTP_NOT_FOUND,
                'message' => "Sensor ID $id tidak ditemukan",
                'data' => null
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'fail',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // DELETE SENSOR
    public function destroy($id)
    {
        try {

            $sensor = Sensor::findOrFail($id);

            $sensor->delete();

            return response()->json([
                'status' => 'success',
                'code' => Response::HTTP_OK,
                'message' => "Berhasil hapus sensor ID $id",
                'data' => null
            ], Response::HTTP_OK);

        } catch (ModelNotFoundException $e) {

            return response()->json([
                'status' => 'fail',
                'code' => Response::HTTP_NOT_FOUND,
                'message' => "Sensor ID $id tidak ditemukan",
                'data' => null
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'fail',
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
                'data' => null
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}