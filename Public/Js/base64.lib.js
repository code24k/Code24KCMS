function EncodeJson(json){
    return {"Stream": EncodeToBase64(JSON.stringify(json))}
}

function DecodeData(data){
    return JSON.parse(DecodeFromBase64(data))
}

/**
 * 将字符串加密为Base64编码
 * @param {string} str - 要加密的字符串
 * @returns {string} - Base64编码后的字符串
 */
function EncodeToBase64(str) {
    try {
        // 首先将字符串编码为UTF-8字节流
        const encoder = new TextEncoder();
        const bytes = encoder.encode(str);
        
        // 创建Base64编码表
        const base64Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        let result = '';
        let padding = 0;
        
        // 每3个字节处理一次
        for (let i = 0; i < bytes.length; i += 3) {
            // 读取3个字节
            const b1 = i < bytes.length ? bytes[i] : 0;
            const b2 = i + 1 < bytes.length ? bytes[i + 1] : 0;
            const b3 = i + 2 < bytes.length ? bytes[i + 2] : 0;
            
            // 转换为4个Base64字符
            const c1 = b1 >> 2;
            const c2 = ((b1 & 0x03) << 4) | (b2 >> 4);
            const c3 = ((b2 & 0x0F) << 2) | (b3 >> 6);
            const c4 = b3 & 0x3F;
            
            // 添加到结果字符串
            result += base64Chars[c1];
            result += base64Chars[c2];
            
            // 处理填充
            if (i + 1 < bytes.length) result += base64Chars[c3];
            else result += '=';
            
            if (i + 2 < bytes.length) result += base64Chars[c4];
            else result += '=';
        }
        
        return result;
    } catch (error) {
        console.error('Base64编码失败:', error);
        return null;
    }
}

/**
 * 将Base64编码的字符串解密为原始字符串
 * @param {string} base64Str - Base64编码的字符串
 * @returns {string} - 解密后的原始字符串
 */
function DecodeFromBase64(base64Str) {
    try {
        // 移除空格并验证Base64格式
        base64Str = base64Str.replace(/\s/g, '');
        if (!/^[A-Za-z0-9+/=]+$/.test(base64Str)) {
            throw new Error('无效的Base64字符串');
        }
        
        // 创建Base64解码表
        const base64Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        const decodeTable = {};
        
        for (let i = 0; i < base64Chars.length; i++) {
            decodeTable[base64Chars[i]] = i;
        }
        
        // 计算填充长度
        let padding = 0;
        if (base64Str.endsWith('==')) padding = 2;
        else if (base64Str.endsWith('=')) padding = 1;
        
        // 解码Base64
        const bytes = [];
        for (let i = 0; i < base64Str.length; i += 4) {
            // 读取4个Base64字符
            const c1 = decodeTable[base64Str[i]];
            const c2 = decodeTable[base64Str[i + 1]];
            const c3 = i + 2 < base64Str.length ? decodeTable[base64Str[i + 2]] : 0;
            const c4 = i + 3 < base64Str.length ? decodeTable[base64Str[i + 3]] : 0;
            
            // 转换为3个字节
            const b1 = (c1 << 2) | (c2 >> 4);
            bytes.push(b1);
            
            if (i + 2 < base64Str.length) {
                const b2 = ((c2 & 0x0F) << 4) | (c3 >> 2);
                bytes.push(b2);
            }
            
            if (i + 3 < base64Str.length) {
                const b3 = ((c3 & 0x03) << 6) | c4;
                bytes.push(b3);
            }
        }
        
        // 移除填充字节
        bytes.splice(bytes.length - padding, padding);
        
        // 将字节转换为字符串
        const decoder = new TextDecoder();
        return decoder.decode(new Uint8Array(bytes));
    } catch (error) {
        console.error('Base64解码失败:', error);
        return null;
    }
}    