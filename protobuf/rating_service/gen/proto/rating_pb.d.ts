// @generated by protoc-gen-es v1.8.0
// @generated from file proto/rating.proto (syntax proto3)
/* eslint-disable */
// @ts-nocheck

import type { BinaryReadOptions, FieldList, JsonReadOptions, JsonValue, PartialMessage, PlainMessage } from "@bufbuild/protobuf";
import { Message, proto3 } from "@bufbuild/protobuf";

/**
 * @generated from message GetRatingRequest
 */
export declare class GetRatingRequest extends Message<GetRatingRequest> {
  /**
   * @generated from field: string game_id = 1;
   */
  gameId: string;

  constructor(data?: PartialMessage<GetRatingRequest>);

  static readonly runtime: typeof proto3;
  static readonly typeName = "GetRatingRequest";
  static readonly fields: FieldList;

  static fromBinary(bytes: Uint8Array, options?: Partial<BinaryReadOptions>): GetRatingRequest;

  static fromJson(jsonValue: JsonValue, options?: Partial<JsonReadOptions>): GetRatingRequest;

  static fromJsonString(jsonString: string, options?: Partial<JsonReadOptions>): GetRatingRequest;

  static equals(a: GetRatingRequest | PlainMessage<GetRatingRequest> | undefined, b: GetRatingRequest | PlainMessage<GetRatingRequest> | undefined): boolean;
}

/**
 * @generated from message GetRatingResponse
 */
export declare class GetRatingResponse extends Message<GetRatingResponse> {
  /**
   * @generated from field: string rating = 1;
   */
  rating: string;

  constructor(data?: PartialMessage<GetRatingResponse>);

  static readonly runtime: typeof proto3;
  static readonly typeName = "GetRatingResponse";
  static readonly fields: FieldList;

  static fromBinary(bytes: Uint8Array, options?: Partial<BinaryReadOptions>): GetRatingResponse;

  static fromJson(jsonValue: JsonValue, options?: Partial<JsonReadOptions>): GetRatingResponse;

  static fromJsonString(jsonString: string, options?: Partial<JsonReadOptions>): GetRatingResponse;

  static equals(a: GetRatingResponse | PlainMessage<GetRatingResponse> | undefined, b: GetRatingResponse | PlainMessage<GetRatingResponse> | undefined): boolean;
}

