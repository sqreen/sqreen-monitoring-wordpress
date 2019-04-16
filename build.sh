output_dir="dist"
output_name="sqreen-monitoring"
version="1.0.0"
mkdir -p ${output_dir}
rm -rf ${output_dir}/*
cp -r src ${output_dir}/${output_name}
cd ${output_dir}
zip -r ${output_name}_${version}.zip $output_name
